<?php

namespace Database\Factories;

use App\Models\Briefing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Briefing>
 */
class BriefingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Briefing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'briefing' => [
                'sections' => [
                    'business_info' => [
                        ['Business segment', fake()->sentence(5, true)],
                        ['Business years', fake()->sentence(5, true)],
                        ['Team size', fake()->randomElement(['Just me', '2-5 people', '6-10 people', '11-20 people', 'More than 20 people'])],
                        ['Current operation', fake()->randomElement(['Fully manual', 'Partially digital', 'I already use software, but need to improve', 'Fully digital'])],
                    ],
                    'problem' => [
                        ['Main problem', fake()->paragraph(3, true)],
                        ['What you tried', fake()->paragraph(3, true)],
                        ['Why now', fake()->paragraph(3, true)],
                        ['Problem impact', implode(', ', fake()->randomElements(['Financial losses', 'Wasted time', 'Manual errors', 'Lack of organization', 'Other'], fake()->numberBetween(1, 3)))],
                        ['Problem affects', fake()->paragraph(3, true)],
                    ],
                    'project' => [
                        ['Essential features', fake()->paragraph(3, true)],
                        ['Reference models', fake()->optional(0.7)->paragraph(3, true)],
                        ['Integrations', implode(', ', fake()->randomElements(['WhatsApp', 'Online payments', 'Google Calendar', 'Internal systems', 'Spreadsheets', 'External API', "I don't know / I need help", 'Other'], fake()->numberBetween(0, 4)))],
                        ['Integration details', fake()->optional(0.5)->paragraph(3, true)],
                    ],
                    'timeline_budget' => [
                        ['Budget reserved', fake()->randomElement(['Yes → I have an amount', 'I have a budget range', "I'm researching", 'Just curious'])],
                        ['Budget amount', fake()->optional(0.5)->sentence(5, true)],
                        ['Urgency', fake()->randomElement(['I want to start this month', 'Next quarter', 'No defined deadline'])],
                        ['Why important', fake()->paragraph(3, true)],
                        ['Can participate', fake()->randomElement(['Yes, daily', 'Yes, a few times per week', 'Difficult to follow'])],
                        ['Prefer meetings', fake()->randomElement(['Yes, periodic meetings', 'Only when necessary', "I don't need meetings"])],
                    ],
                    'materials' => [
                        ['Logo', fake()->boolean() ? 'Yes' : 'No'],
                        ['Visual identity', fake()->boolean() ? 'Yes' : 'No'],
                        ['Domain', fake()->boolean() ? 'Yes' : 'No'],
                        ['Hosting', fake()->boolean() ? 'Yes' : 'No'],
                        ['Texts and images', fake()->boolean() ? 'Yes' : 'No'],
                        ['None', fake()->boolean() ? 'Yes' : 'No'],
                        ['Domain name', fake()->optional(0.3)->domainName()],
                        ['Account access', fake()->optional(0.7)->randomElement(['Yes, I have access to everything', 'Yes, I have access to some', "No, I don't have access", 'Not sure'])],
                        ['Existing documents', fake()->optional(0.6)->paragraph(3, true)],
                    ],
                    'contact_info' => [
                        ['Preferred contact method', fake()->optional(0.7)->randomElement(['Email', 'Phone', 'WhatsApp', 'Either'])],
                        ['Planning to hire', fake()->randomElement(['Yes', 'Probably', 'Maybe', 'No'])],
                        ['Final delivery', fake()->paragraph(3, true)],
                        ['Additional info', fake()->optional(0.5)->paragraph(3, true)],
                    ],
                ],
            ],
            'status' => fake()->randomElement(['new', 'done']),
        ];
    }
}
