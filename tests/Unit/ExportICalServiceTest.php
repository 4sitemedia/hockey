<?php

namespace Tests\Unit;

use App\Contracts\ExportContract;
use App\Services\ExportICalService;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class ExportICalServiceTest extends TestCase
{
    private ?ExportICalService $exportICalService;

    protected function setUp(): void
    {
        $this->exportICalService = new ExportICalService;
    }

    protected function tearDown(): void
    {
        $this->exportICalService = null;
    }

    /**
     * verify that the ExportICalService class is instantiable
     */
    public function test_is_instantiable(): void
    {
        $this->assertInstanceOf(ExportICalService::class, $this->exportICalService);
    }

    /**
     * verify that the buildSummary method returns the expected value
     *
     * @param  array<string>  $awayTeam
     * @param  array<string>  $homeTeam
     */
    #[TestWith([
        ['fullName' => 'Away Location Name'],
        ['fullName' => 'Home Location Name'],
        true,
        true,
        ExportContract::TEXT_TRANSFORM_NONE,
        'Away Location Name at Home Location Name',
    ])]
    #[TestWith([
        ['fullName' => 'Away Location Name'],
        ['fullName' => 'Home Location Name'],
        true,
        true,
        ExportContract::TEXT_TRANSFORM_LOWERCASE,
        'away location name at home location name',
    ])]
    #[TestWith([
        ['fullName' => 'Away Location Name'],
        ['fullName' => 'Home Location Name'],
        true,
        true,
        ExportContract::TEXT_TRANSFORM_UPPERCASE,
        'AWAY LOCATION NAME AT HOME LOCATION NAME',
    ])]
    #[TestWith([
        ['location' => 'Away Location'],
        ['location' => 'Home Location'],
        true,
        false,
        ExportContract::TEXT_TRANSFORM_NONE,
        'Away Location at Home Location',
    ])]
    #[TestWith([
        ['location' => 'Away Location'],
        ['location' => 'Home Location'],
        true,
        false,
        ExportContract::TEXT_TRANSFORM_LOWERCASE,
        'away location at home location',
    ])]
    #[TestWith([
        ['location' => 'Away Location'],
        ['location' => 'Home Location'],
        true,
        false,
        ExportContract::TEXT_TRANSFORM_UPPERCASE,
        'AWAY LOCATION AT HOME LOCATION',
    ])]
    #[TestWith([
        ['name' => 'Away Name'],
        ['name' => 'Home Name'],
        false,
        true,
        ExportContract::TEXT_TRANSFORM_NONE,
        'Away Name at Home Name',
    ])]
    #[TestWith([
        ['name' => 'Away Name'],
        ['name' => 'Home Name'],
        false,
        true,
        ExportContract::TEXT_TRANSFORM_LOWERCASE,
        'away name at home name',
    ])]
    #[TestWith([
        ['name' => 'Away Name'],
        ['name' => 'Home Name'],
        false,
        true,
        ExportContract::TEXT_TRANSFORM_UPPERCASE,
        'AWAY NAME AT HOME NAME',
    ])]
    public function test_build_summary(array $awayTeam, array $homeTeam, bool $exportLocation, bool $exportName, string $textTransform, string $expected): void
    {
        $this->assertInstanceOf(ExportICalService::class, $this->exportICalService);

        $this->exportICalService->setOptions($exportLocation, $exportName, false, null, $textTransform);

        $this->assertEquals($expected, $this->exportICalService->buildSummary($awayTeam, $homeTeam));
    }

    /**
     * verify that the transformText method returns the expected value
     */
    #[TestWith([
        'Test Text',
        ExportContract::TEXT_TRANSFORM_NONE,
        'Test Text',
    ])]
    #[TestWith([
        'Test Text',
        ExportContract::TEXT_TRANSFORM_LOWERCASE,
        'test text',
    ])]
    #[TestWith([
        'Test Text',
        ExportContract::TEXT_TRANSFORM_UPPERCASE,
        'TEST TEXT',
    ])]
    public function test_transform_text(string $text, string $textTransform, string $expected): void
    {
        $this->assertInstanceOf(ExportICalService::class, $this->exportICalService);

        $this->exportICalService->setOptions(false, false, false, null, $textTransform);

        $this->assertEquals($expected, $this->exportICalService->transformText($text));
    }
}
