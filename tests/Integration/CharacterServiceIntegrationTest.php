<?php

use App\Services\CharacterService;
use App\Services\HouseService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Testing for the HouseService class
 */
class CharacterServiceIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    protected CharacterService $characterService;

    /**
     * Extending setUp() to create a HouseService object 
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->characterService = new CharacterService(
            new HouseService()
        );
    }

    /**
     * Testing save characters with no arguments
     *
     * @return void
     */
    public function testSaveCharNoArguments()
    {
        $this->expectException(\Error::class);

        $char = $this->characterService->save();
        
    }

    /**
     * Testing save characters with wrong types
     *
     * @return void
     */
    public function testSaveCharWrongTypes()
    {
        $this->expectException(\Error::class);

        $char = $this->characterService->save(
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1
        );
        
    }

    /**
     * Testing save characters with wrong types
     *
     * @return void
     */
    public function testUpdateCharWrongTypes()
    {
        $this->expectException(\Error::class);

        $char = $this->characterService->save(
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            'xxx'
        );
        
    }


    public function testSaveChar()
    {
        $char = $this->characterService->save(
            '1760529f-6d51-4cb1-bcb1-25087fce5bde',
            'Harry',
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $this->assertNotEmpty($char);
    }
}
