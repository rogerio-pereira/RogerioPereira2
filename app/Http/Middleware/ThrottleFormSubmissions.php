<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ThrottleFormSubmissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();
        $routeName = $route->getName();
        $formType = str_replace('.store', '', $routeName);

        $ipAddress = $request->ip();
        $maskedIp = md5($ipAddress);

        $currentTime = Carbon::now();

        $isBlocked = $this->isBlocked($maskedIp, $currentTime);
        if ($isBlocked) {
            return $this->returnBlockedError($maskedIp, $currentTime);
        }

        $hasAlreadySubmitted = $this->hasAlreadySubmittedFormToday($maskedIp, $formType, $currentTime);
        if ($hasAlreadySubmitted) {
            $errorMessage = 'You have already submitted this form today. Please try again tomorrow.';

            return redirect()
                ->back()
                ->with('error', $errorMessage);
        }

        $submissionsCountToday = $this->getSubmissionsCountToday($maskedIp);
        if ($submissionsCountToday >= 3) {
            $this->blockForSevenDays($maskedIp, $currentTime);
            $errorMessage = 'You have reached the limit of 3 submissions per day. Please try again in 7 days.';

            return redirect()
                ->back()
                ->with('error', $errorMessage);
        }

        $email = $request->input('email');
        if ($email) {
            $isDomainExceeded = $this->hasExceededEmailDomainLimit($ipAddress, $email, $currentTime);
            if ($isDomainExceeded) {
                $this->blockForSevenDays($maskedIp, $currentTime);
                $errorMessage = 'Suspicious activity detected. Please try again in 7 days.';

                return redirect()
                    ->back()
                    ->with('error', $errorMessage);
            }
        }

        $response = $next($request);

        $isSuccessful = $this->isSuccessfulResponse($response);
        if ($isSuccessful) {
            $this->recordSuccessfulSubmission($maskedIp, $formType, $ipAddress, $email, $submissionsCountToday, $currentTime);
        }

        return $response;
    }

    /**
     * Check if the IP is currently blocked
     */
    private function isBlocked(string $identifier, Carbon $currentTime): bool
    {
        $blockedUntil = Cache::get("form_submission_blocked:{$identifier}");

        if ($blockedUntil === null) {
            return false;
        }

        return $currentTime->isBefore($blockedUntil);
    }

    /**
     * Return error message when user is blocked
     */
    private function returnBlockedError(string $identifier, Carbon $currentTime)
    {
        $blockedUntil = Cache::get("form_submission_blocked:{$identifier}");
        $daysDifference = $currentTime->diffInDays($blockedUntil, false);
        $daysRemaining = $daysDifference + 1;
        $errorMessage = "You have reached the submission limit. Please try again in {$daysRemaining} day(s).";

        return redirect()
            ->back()
            ->with('error', $errorMessage);
    }

    /**
     * Check if user has already submitted this specific form today
     */
    private function hasAlreadySubmittedFormToday(string $identifier, string $formType, Carbon $currentTime): bool
    {
        $today = $currentTime->format('Y-m-d');
        $cacheKey = "form_submission:{$identifier}:{$formType}:{$today}";

        return Cache::has($cacheKey);
    }

    /**
     * Block the IP for 7 days
     */
    private function blockForSevenDays(string $identifier, Carbon $currentTime): void
    {
        $blockedUntil = $currentTime->copy()->addDays(7);
        $cacheKey = "form_submission_blocked:{$identifier}";

        Cache::put($cacheKey, $blockedUntil, $blockedUntil);
    }

    /**
     * Check if IP has exceeded email domain submission limit
     */
    private function hasExceededEmailDomainLimit(string $ipAddress, string $email, Carbon $currentTime): bool
    {
        $emailDomain = $this->extractEmailDomain($email);
        $today = $currentTime->format('Y-m-d');
        $cacheKey = "form_submission_domain:{$ipAddress}:{$emailDomain}:{$today}";

        $domainSubmissionsCount = Cache::get($cacheKey, 0);

        return $domainSubmissionsCount >= 3;
    }

    /**
     * Check if response indicates successful submission
     */
    private function isSuccessfulResponse(Response $response): bool
    {
        $statusCode = $response->getStatusCode();

        return $statusCode === 302 || $statusCode === 200;
    }

    /**
     * Record successful submission in cache
     */
    private function recordSuccessfulSubmission(
        string $identifier,
        string $formType,
        string $ipAddress,
        ?string $email,
        int $submissionsCountToday,
        Carbon $currentTime
    ): void {
        $today = $currentTime->format('Y-m-d');
        $tomorrow = $currentTime->copy()
            ->addDay()
            ->startOfDay();
        $secondsUntilMidnight = $currentTime->diffInSeconds($tomorrow);

        $formCacheKey = "form_submission:{$identifier}:{$formType}:{$today}";
        Cache::put($formCacheKey, true, $secondsUntilMidnight);

        $newSubmissionsCount = $submissionsCountToday + 1;
        if ($newSubmissionsCount >= 3) {
            $this->blockForSevenDays($identifier, $currentTime);
        }

        if ($email) {
            $this->incrementEmailDomainCounter($ipAddress, $email, $currentTime, $secondsUntilMidnight);
        }
    }

    /**
     * Increment email domain submission counter
     */
    private function incrementEmailDomainCounter(string $ipAddress, string $email, Carbon $currentTime, int $expiresInSeconds): void
    {
        $emailDomain = $this->extractEmailDomain($email);
        $today = $currentTime->format('Y-m-d');
        $cacheKey = "form_submission_domain:{$ipAddress}:{$emailDomain}:{$today}";

        $currentCount = Cache::get($cacheKey, 0);
        $newCount = $currentCount + 1;

        Cache::put($cacheKey, $newCount, $expiresInSeconds);
    }

    /**
     * Get the count of different submissions made today
     */
    private function getSubmissionsCountToday(string $identifier): int
    {
        $today = Carbon::today()->format('Y-m-d');
        $submissionCount = 0;

        $formTypes = ['automation', 'software-development', 'marketing'];

        foreach ($formTypes as $formType) {
            $cacheKey = "form_submission:{$identifier}:{$formType}:{$today}";

            if (Cache::has($cacheKey)) {
                $submissionCount++;
            }
        }

        return $submissionCount;
    }

    /**
     * Extract the domain from an email address
     */
    private function extractEmailDomain(string $email): string
    {
        $emailLowercase = strtolower($email);
        $parts = explode('@', $emailLowercase);
        $domain = $parts[1] ?? 'unknown';

        return $domain;
    }
}
