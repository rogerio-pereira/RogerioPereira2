/**
 * Read Laravel's encrypted XSRF cookie for authenticated fetch calls.
 */
export function getXsrfToken(): string {
    const cookies = document.cookie.split(';');

    for (const cookie of cookies) {
        const trimmed = cookie.trim();
        const prefix = 'XSRF-TOKEN=';

        if (!trimmed.startsWith(prefix)) {
            continue;
        }

        const value = trimmed.slice(prefix.length);

        return decodeURIComponent(value);
    }

    return '';
}
