<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMemberTableAddPartnersAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `members` 

            ADD COLUMN `nationality_id` BIGINT(20) UNSIGNED NULL AFTER `language_id`,
            ADD COLUMN `working_with_id` BIGINT(20) UNSIGNED NULL AFTER `language_id`,
            ADD COLUMN `marital_status_id` BIGINT(20) UNSIGNED NULL AFTER `language_id`,
            ADD COLUMN `specialization_id` BIGINT(20) UNSIGNED NULL AFTER `language_id`,
            ADD COLUMN `job_id` BIGINT(20) UNSIGNED NULL AFTER `language_id`,
            ADD COLUMN `looking_for_id` BIGINT(20) UNSIGNED NULL AFTER `language_id`,

            ADD COLUMN `country_id` BIGINT(20) UNSIGNED NULL AFTER `device_id`,
            ADD COLUMN `state_id` BIGINT(20) UNSIGNED   NULL AFTER `country_id`,
            ADD COLUMN `city_id` BIGINT(20) UNSIGNED   NULL AFTER `state_id`,
            ADD COLUMN `postal_code` INTEGER(11)   NULL AFTER `city_id`,
            ADD COLUMN `education_id` BIGINT(20) UNSIGNED   NULL AFTER `postal_code`,
            ADD COLUMN `occupation_id` BIGINT(20) UNSIGNED   NULL AFTER `education_id`,
            ADD COLUMN `weight` VARCHAR(30) NULL AFTER `occupation_id`,
            ADD COLUMN `eye_color` VARCHAR(30) NULL AFTER `weight`,
            ADD COLUMN `hair_color` VARCHAR(30) NULL AFTER `eye_color`,
            ADD COLUMN `complexion` VARCHAR(30) NULL AFTER `hair_color`,
            ADD COLUMN `blood_group` VARCHAR(30) NULL AFTER `complexion`,
            ADD COLUMN `body_type` VARCHAR(30) NULL AFTER `blood_group`,
            ADD COLUMN `any_desability` VARCHAR(30) NULL AFTER `body_type`,
           
            ADD COLUMN `mother_language_id` BIGINT(20) UNSIGNED   NULL AFTER `any_desability`,
            ADD COLUMN `speek_language_id` BIGINT(20) UNSIGNED   NULL AFTER `mother_language_id`, 
            ADD COLUMN `read_language_id` BIGINT(20) UNSIGNED   NULL AFTER `speek_language_id`,
            ADD COLUMN `birthday_country_id` BIGINT(20) UNSIGNED   NULL AFTER `read_language_id`,
            ADD COLUMN `residency_country_id` BIGINT(20) UNSIGNED   NULL AFTER `birthday_country_id`,
            ADD COLUMN `immigration_status` VARCHAR(30)  NULL AFTER `residency_country_id`,
            ADD COLUMN `religion_id` BIGINT(20) UNSIGNED   NULL AFTER `residency_country_id`,
            ADD COLUMN `caste_id` BIGINT(20) UNSIGNED   NULL AFTER `residency_country_id`,
            ADD COLUMN `ethniciy` VARCHAR(30)   NULL AFTER `caste_id`,
            ADD COLUMN `personal_value` VARCHAR(30)   NULL AFTER `ethniciy`,
            ADD COLUMN `family_value_id` BIGINT(20)  UNSIGNED NULL AFTER `personal_value`,
            ADD COLUMN `community_value` VARCHAR(30) NULL AFTER `family_value_id`,
            ADD COLUMN `family_status_id` BIGINT(20)  UNSIGNED NULL AFTER `community_value`,
            ADD COLUMN `manglik` TINYINT(1) NULL AFTER `family_status_id`,
            ADD COLUMN `star_sign` TINYINT(1) NULL AFTER `manglik`,
            ADD COLUMN `father_name` VARCHAR(60) NULL AFTER `star_sign`,
            ADD COLUMN `mother_name` VARCHAR(60) NULL AFTER `father_name`,
            ADD COLUMN `brothers_sisters` VARCHAR(60) NULL AFTER `mother_name`,
            ADD COLUMN `home_district` VARCHAR(60) NULL AFTER `brothers_sisters`, 
            ADD COLUMN `family_residence` VARCHAR(60) NULL AFTER `home_district`,
            ADD COLUMN `father_occupation_id` BIGINT(20) UNSIGNED NULL AFTER `family_residence`,
            ADD COLUMN `special_circumstances` VARCHAR(60) NULL AFTER `father_occupation_id`,
            ADD COLUMN `partner_general_requirement` VARCHAR(255) NULL AFTER `special_circumstances`, 
            ADD COLUMN `partner_age` INTEGER(11) NULL AFTER `partner_general_requirement`,
            ADD COLUMN `partner_height` VARCHAR(30) NULL AFTER `partner_age`, 
            ADD COLUMN `partner_weight` VARCHAR(30) NULL AFTER `partner_height`, 
            ADD COLUMN `partner_marital_status_id`  BIGINT(20) UNSIGNED NULL AFTER `partner_weight`,  
            ADD COLUMN `partner_with_children_acceptable`  TINYINT(1) UNSIGNED NULL AFTER `partner_marital_status_id`, 
            ADD COLUMN `partner_country_residence_id`  BIGINT(20) UNSIGNED NULL AFTER `partner_with_children_acceptable`, 
            ADD COLUMN `partner_religion_id`  BIGINT(20) UNSIGNED NULL AFTER `partner_country_residence_id`, 
            ADD COLUMN `partner_education_id`  BIGINT(20) UNSIGNED NULL AFTER `partner_religion_id`, 
            ADD COLUMN `partner_caste_id`  BIGINT(20) UNSIGNED NULL AFTER `partner_education_id`, 
            ADD COLUMN `partner_profession`  VARCHAR(40) NULL AFTER `partner_caste_id`, 
            ADD COLUMN `partner_complexion`  VARCHAR(40) NULL AFTER `partner_profession`, 
            ADD COLUMN `partner_drinking_habits`  TINYINT(1) UNSIGNED NULL AFTER `partner_complexion`,
            ADD COLUMN `partner_smoking_habits`  TINYINT(1) UNSIGNED NULL AFTER `partner_drinking_habits`,
            ADD COLUMN `partner_diet`  VARCHAR(100) NULL AFTER `partner_smoking_habits`,
            ADD COLUMN `partner_body_type`  VARCHAR(100) NULL AFTER `partner_diet`,
            ADD COLUMN `partner_personal_value`  VARCHAR(100) NULL AFTER `partner_body_type`,
            ADD COLUMN `partner_manglik`  VARCHAR(100) NULL AFTER `partner_personal_value`,
            ADD COLUMN `partner_desablity`  VARCHAR(100) NULL AFTER `partner_manglik`,
            ADD COLUMN `partner_mother_language_id`  BIGINT(20) UNSIGNED NULL AFTER `partner_desablity`, 
            ADD COLUMN `partner_family_value_id`  BIGINT(20) UNSIGNED NULL AFTER `partner_mother_language_id`,
            ADD COLUMN `partner_prefered_status` VARCHAR(100) NULL AFTER `partner_family_value_id`, 
            ADD COLUMN `partner_prefered_country_id`  BIGINT(20) UNSIGNED NULL AFTER `partner_prefered_status`,
            ADD COLUMN `partner_prefered_state_id`  BIGINT(20) UNSIGNED NULL AFTER `partner_prefered_country_id` ;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
