<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => fake()->realTextBetween(300, 1000), // Génération d'un texte aléatoire pour le post
            'img_path' => function () {
                $randomName = Str::uuid();  // Génération d'un nom unique pour le fichier
                $imageUrl = "https://picsum.photos/1080/1080.webp?random={$randomName}"; // Génération d'une image aléatoire à l'aide du service Picsum
                $path = "images/{$randomName}.webp"; // Chemin pour enregistrer l'image
                Storage::disk('public')->put($path, file_get_contents($imageUrl)); // Enregistrement de l'image dans le répertoire public

                return $path;
            },
            'user_id' => User::inRandomOrder()->first()->id, // Association du post avec un utilisateur aléatoire de la table users
        ];
    }
}
