<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Controllers\ConsultationController;
use App\Models\Admin;
use App\Models\City;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Medical;
use App\Models\Patient;
use App\Models\Personal;
use App\Models\Post;
use App\Models\Question;
use App\Models\Region;
use App\Models\Reply;
use App\Models\Specialization;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

       $damascus = City::factory()->create([
            'name' => 'دمشق',
        ]);
       $ref = City::factory()->create([
            'name' => 'ريف دمشق',
        ]);
       $dir = City::factory()->create([
            'name' => 'درعا',
        ]);
       $dir = City::factory()->create([
            'name' => 'السويداء',
        ]);
       $dir = City::factory()->create([
            'name' => 'دير الزور',
        ]);
       $dir = City::factory()->create([
            'name' => 'حمص',
        ]);
       $dir = City::factory()->create([
            'name' => 'حلب',
        ]);
       $dir = City::factory()->create([
            'name' => 'اللاذقية',
        ]);
       $dir = City::factory()->create([
            'name' => 'طرطوس',
        ]);
       $dir = City::factory()->create([
            'name' => 'حماة',
        ]);
    
       Specialization::factory()->create([
            'name' => 'جلدية',
            'image' => 'https://i.ibb.co/6FSjntT/allergy-1.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'نسائية',
            'image' => 'https://i.ibb.co/mqTQpFf/pregnant-3.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'اطفال',
            'image' => 'https://i.ibb.co/94NvxRd/baby-1.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'عضمية',
            'image' => 'https://i.ibb.co/nzTQ7sN/bone-1.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'اسنان',
            'image' => 'https://i.ibb.co/CPL5NHV/tooth-1.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'عصبية',
            'image' => 'https://i.ibb.co/MPxrJXx/brain-1.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'كلية -بولية',
            'image' => 'https://i.ibb.co/cCCRBKY/kidney-33.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'انف - حنجرة',
            'image' => 'https://i.ibb.co/FgFQjSB/thyroid-1.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'عينية',
            'image' => 'https://i.ibb.co/prg494Q/oculist-1.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'قلبية',
            'image' => 'https://i.ibb.co/qNQj1sB/heart-1.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'هضمية',
            'image' => 'https://i.ibb.co/z4nnRjq/stomach-1.png'
        ]);
            
       Specialization::factory()->create([
            'name' => 'داخلية',
            'image' => 'https://i.ibb.co/d5KwtLG/esophagus-1.png'
        ]);
        
    //   $eye = Specialization::factory()->create([
    //         'name' => 'عينية',
    //         'image' => 'https://t3.ftcdn.net/jpg/01/19/75/26/360_F_119752602_gm4OfWfuBRw8rOKaXqMgSSjNPjgyhNPE.jpg',
    //     ]);
    //   $head = Specialization::factory()->create([
    //         'name' => 'اطفال',
    //         'image' => 'https://thumbs.dreamstime.com/b/child-care-doctor-family-medicine-pediatrics-blue-icon-beautiful-meticulously-designed-well-organized-editable-vector-any-188490798.jpg',
    //     ]);
    //   $yazanp =  Patient::factory()->create([
    //         'name' => 'yazan',
    //         'email' => 'yazan@patient.com',
    //         'password' => 'password',
    //         'city_id'=> $damascus->id
    //     ]);
    //   $ghaithp=  Patient::factory()->create([
    //         'name' => 'ghaith',
    //         'email' => 'ghaith@patient.com',
    //         'password' => 'password',
    //         'city_id'=> $ref->id
    //     ]);
    //   $salehp = Patient::factory()->create([
    //         'name' => 'saleh',
    //         'email' => 'saleh@patient.com',
    //         'password' => 'password',
    //         'city_id'=> $dir->id

    //     ]);
    //   $yazand = Doctor::factory()->create([
    //         'name' => 'yazan',
    //         'email' => 'yazan@doctor.com',
    //         'password' => 'password',
    //         'city_id'=> $damascus->id,
    //         'specialization_id'=> $heart->id
    //     ]);
    //   $ghaithd = Doctor::factory()->create([
    //         'name' => 'ghaith',
    //         'email' => 'ghaith@doctor.com',
    //         'password' => 'password',
    //         'city_id'=> $ref->id,
    //         'specialization_id'=> $eye->id
    //     ]);
    //     $salehd = Doctor::factory()->create([
    //         'name' => 'saleh',
    //         'email' => 'saleh@doctor.com',
    //         'password' => 'password',
    //         'city_id'=> $dir->id,
    //         'specialization_id'=> $head->id
    //     ]);
    //     Personal::factory()->create(['patient_id' => $ghaithp->id]);
    //     Personal::factory()->create(['patient_id' => $yazanp->id]);
    //     Personal::factory()->create(['patient_id' => $salehp->id]);

    //     Medical::factory()->create(['patient_id' => $ghaithp->id]);
    //     Medical::factory()->create(['patient_id' =>  $yazanp->id]);
    //     Medical::factory()->create(['patient_id' =>  $salehp->id]);

    //     Consultation::factory(3)->create(['patient_id' => $ghaithp->id,'specialization_id'=>$salehd->specialization_id]);
    //     Consultation::factory()->create(['patient_id' => $salehp->id,'specialization_id'=>$salehd->specialization_id,'doctor_id'=>$salehd->id]);
    //     Consultation::factory()->create(['patient_id' => $yazanp->id,'specialization_id'=>$salehd->specialization_id,'doctor_id'=>$salehd->id]);
    //     Consultation::factory()->create(['patient_id' => $yazanp->id,'specialization_id'=>$ghaithd->specialization_id]);

    //     Question::factory(3)->create(['patient_id' => $ghaithp->id,'specialization_id'=>$salehd->specialization_id]);
    //   $question = Question::factory()->create(['patient_id' => $yazanp->id,'specialization_id'=>$salehd->specialization_id]);

    //     Reply::factory()->create(['doctor_id'=>$salehd->id,'question_id'=>$question->id]);

    //     Post::factory(3)->create(['specialization_id'=>$salehd->specialization_id,'doctor_id'=>$salehd->id]);

        Admin::factory(1)->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'password'
        ]);

    }
}
