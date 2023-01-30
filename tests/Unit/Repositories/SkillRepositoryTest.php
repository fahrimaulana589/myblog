<?php

namespace Tests\Unit\Repositories;

use App\Models\Skill;
use App\Repositories\Skill\SkillRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class SkillRepositoryTest extends TestCase
{
    public function test_ambil_semua_skill()
    {
        Skill::factory(5)->create();

        $skillRepository = app()->make(SkillRepository::class);

        $sskills = $skillRepository->all();

        $this->assertTrue($sskills->count() == 5);
    }

    public function test_ambil_detail_skill_dengan_id()
    {
        $skills = Skill::factory(5)->create();

        $skillRepository = app()->make(SkillRepository::class);

        $skill = $skillRepository->find($skills->first()->id);

        $this->assertTrue($skill->id == $skills->first()->id);
    }

     public function test_ambil_detail_skill_dengan_id_tidak_ada()
     {
         $this->expectException(ModelNotFoundException::class);

         Skill::factory(5)->create();

         $skillRepository = app()->make(SkillRepository::class);

         $skillRepository->findOrFail(121);
     }

     public function test_buat_data_skill()
     {
         $skillRepository = app()->make(SkillRepository::class);

         $skill = $skillRepository->create([
             'icon' => fake()->imageUrl(),
             'name' => 'test',
         ]);

         $this->assertDatabaseCount('skills', 1);
     }

      public function test_buat_data_skill_dengan_gambar_sama_akan_eror()
      {
          $this->expectException(QueryException::class);

          $skillRepository = app()->make(SkillRepository::class);

          $gambar = fake()->imageUrl();

          $skill = $skillRepository->create([
              'icon' => $gambar,
              'name' => 'test',
          ]);

          $skill = $skillRepository->create([
              'icon' => $gambar,
              'name' => 'test',
          ]);
      }

     public function test_buat_data_skill_dengan_nama_sama_akan_eror()
     {
         $this->expectException(QueryException::class);

         $skillRepository = app()->make(SkillRepository::class);

         $nama = 'php';

         $skill = $skillRepository->create([
             'icon' => fake()->imageUrl(),
             'name' => $nama,
         ]);

         $skill = $skillRepository->create([
             'icon' => fake()->imageUrl(),
             'name' => $nama,
         ]);
     }

     public function test_buat_data_skill_dengan_gambar_tidak_ada_akan_eror()
     {
         $this->expectException(QueryException::class);

         $skillRepository = app()->make(SkillRepository::class);

         $skill = $skillRepository->create([
             'name' => 'test',
         ]);
     }

     public function test_buat_data_skill_dengan_nama_tidak_ada_akan_eror()
     {
         $this->expectException(QueryException::class);

         $skillRepository = app()->make(SkillRepository::class);

         $skill = $skillRepository->create([
             'icon' => fake()->imageUrl,
         ]);
     }

     public function test_update_data_skill_dengan_id()
     {
         $idSkill = Skill::factory(5)->create()->first()->id;

         $skillRepository = app()->make(SkillRepository::class);

         $skill = $skillRepository->update($idSkill, [
             'icon' => 'teasst.jpg',
         ]);

         $this->assertDatabaseHas('skills', [
             'icon' => 'teasst.jpg',
         ]);
     }

     public function test_update_data_skill_dengan_id_tidak_ada_akan_eror()
     {
         $this->expectException(ModelNotFoundException::class);

         $idSkill = Skill::factory(5)->create()->first()->id;

         $skillRepository = app()->make(SkillRepository::class);

         $skill = $skillRepository->update(121, [
             'icon' => 'teasst.jpg',
         ]);
     }

     public function test_update_data_skill_dengan_nama_sudah_ada_akan_eror()
     {
         $this->expectException(QueryException::class);

         $data1 = Skill::factory()->create([
             'name' => 'teasst.jpg',
         ]);
         $data2 = Skill::factory()->create();

         $skillRepository = app()->make(SkillRepository::class);

         $skill = $skillRepository->update($data2->id, [
             'name' => 'teasst.jpg',
         ]);
     }

     public function test_update_data_skill_dengan_icon_sudah_ada_akan_eror()
     {
         $this->expectException(QueryException::class);

         $data1 = Skill::factory()->create([
             'icon' => 'teasst.jpg',
         ]);
         $data2 = Skill::factory()->create();

         $skillRepository = app()->make(SkillRepository::class);

         $skill = $skillRepository->update($data2->id, [
             'icon' => 'teasst.jpg',
         ]);
     }

     public function test_delete_skill_dari_id()
     {
         $skill = Skill::factory()->create();

         $skillRepository = app()->make(SkillRepository::class);

         $skillRepository->delete($skill->id);

         $this->assertDatabaseCount('skills', 0);
     }

     public function test_delete_skill_dari_id_tidak_ada_akan_eror()
     {
         $this->expectException(ModelNotFoundException::class);

         $skillRepository = app()->make(SkillRepository::class);

         $skillRepository->delete(121212);

         $this->assertDatabaseCount('skills', 0);
     }
}
