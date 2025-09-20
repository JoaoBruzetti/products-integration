<?php

namespace Tests\Unit;

use App\Services\ProductImportService;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use Mockery;

class ProductImportServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function getService(): ProductImportService
    {
        return new ProductImportService(
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

        public function test_importa_produtos_validos_e_insere_na_tabela()
    {
        $mockRepo = Mockery::mock(ProductRepository::class);
        File::shouldReceive('exists')->once()->andReturn(true);
        File::shouldReceive('get')->once()->andReturn(json_encode([
            [
                'referencia' => 1,
                'nome' => 'Produto Teste',
                'preco' => 10,
            ]
        ]));
        $mockRepo->shouldReceive('getAll')->once()->andReturn([]);
        $mockRepo->shouldReceive('insertAll')->once()->with(Mockery::on(function($arg) {
            return
            is_array($arg)
            && count($arg) === 1
            && $arg[0]['id'] === "1"
            && $arg[0]['name'] === 'Produto Teste'
            && $arg[0]['price'] === 10.0
            && $arg[0]['code'] === null
            && $arg[0]['description'] === null
            && $arg[0]['composition'] === null
            && $arg[0]['brand'] === null
            && $arg[0]['price_promotional'] === 0.0
            && $arg[0]['weight'] === null
            && $arg[0]['height'] === null
            && $arg[0]['width'] === null
            && $arg[0]['length'] === null;
        }))->andReturnTrue();
        $service = new ProductImportService($mockRepo);
        $result = $service->import('produtos.json');
        $this->assertIsString($result);
    }

    public function test_importa_produtos_sem_nenhum_valido_nada_inserido()
    {
        $mockRepo = Mockery::mock(ProductRepository::class);
        File::shouldReceive('exists')->once()->andReturn(true);
        File::shouldReceive('get')->once()->andReturn(json_encode([
            ['id' => 2] // faltam campos obrigatórios
        ]));
        $mockRepo->shouldReceive('getAll')->once()->andReturn([]);
        $mockRepo->shouldNotReceive('insertAll');
        $service = new ProductImportService($mockRepo);
        $result = $service->import('produtos.json');
        $this->assertIsString($result);
    }
}
