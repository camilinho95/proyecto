<?php

use Illuminate\Database\Seeder;
use App\Carta;

class SolicitudesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carta::create([
            'IdManzana' => 'Juan meneses',
            'estado' => 'sin resolver',
            'comentario' => 'carta de prueba desde Ventanilla',
        ]);

    }
}
