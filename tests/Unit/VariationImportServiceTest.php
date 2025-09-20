<?php

namespace Tests\Unit;

use App\Services\VariationImportService;
use App\Repositories\ProductRepository;
use App\Repositories\VariationRepository;
use App\Repositories\ColorRepository;
use App\Repositories\SizeRepository;
use App\Repositories\UnitRepository;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use Mockery;

class VariationImportServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function getService(): VariationImportService
    {
        $colorRepo = Mockery::mock(ColorRepository::class);
        $colorRepo->shouldReceive('getAll')->andReturn([]);

        $sizeRepo = Mockery::mock(SizeRepository::class);
        $sizeRepo->shouldReceive('getAll')->andReturn([]);

        $unitRepo = Mockery::mock(UnitRepository::class);
        $unitRepo->shouldReceive('getAll')->andReturn([]);

        return new VariationImportService(
            Mockery::mock(VariationRepository::class),
            $colorRepo,
            $sizeRepo,
            $unitRepo,
            Mockery::mock(ProductRepository::class)
        );
    }

    public function test_retorna_erro_se_arquivo_nao_existir()
    {
        File::shouldReceive('exists')->once()->andReturn(false);
        $service = $this->getService();
        $result = $service->import('arquivo_inexistente.json');
        $this->assertStringContainsString('Arquivo arquivo_inexistente.json não encontrado', $result);
    }

    public function test_retorna_erro_se_json_invalido()
    {
        File::shouldReceive('exists')->once()->andReturn(true);
        File::shouldReceive('get')->once()->andReturn('not a json');
        $service = $this->getService();
        $result = $service->import('arquivo.json');
        $this->assertStringContainsString('Arquivo arquivo.json inválido', $result);
    }
}
