<?php

namespace Bojka\Roster\Tests\Objects;

use Bojka\Roster\Objects\Profile;
use WP_UnitTestCase;

class TestProfile extends WP_UnitTestCase
{
    public function test_fromArray(): void
    {
        $object = Profile::fromArray([
            'name'                      => 'testName',
            'baptismal_name'            => 'testBaptismalName',
            'birthday'                  => '2025-01-02',
            'current_assignment'        => 'test_0',
            'date_of_death'             => '2025-01-03',
            'departure_date'            => '2025-01-04',
            'entrance_date'             => '2025-01-05',
            'former_assignments'        => "test_1\r\ntest_2\r\ntest_3",
            'initial_profession_date'   => '2025-01-06',
            'monastic_name'             => 'testerMonasticName',
            'ordination_date'           => '2025-01-07',
            'perpetual_profession_date' => '2025-01-08',
            'profile_image'             => [],
        ]);

        $this->assertEquals(0, $object->id);
        $this->assertEquals('testName', $object->name);
        $this->assertEquals('testBaptismalName', $object->baptismalName);
        $this->assertEquals('2025-01-02', $object->birthday);
        $this->assertEquals('test_0', $object->currentAssignment);
        $this->assertEquals('2025-01-03', $object->dateOfDeath);
        $this->assertEquals('2025-01-04', $object->departureDate);
        $this->assertEquals('2025-01-05', $object->entranceDate);
        $this->assertEquals("test_1\r\ntest_2\r\ntest_3", $object->formerAssignments);
        $this->assertEquals('2025-01-06', $object->initialProfessionDate);
        $this->assertEquals('testerMonasticName', $object->monasticName);
        $this->assertEquals('2025-01-07', $object->ordinationDate);
        $this->assertEquals('2025-01-08', $object->perpetualProfessionDate);
        $this->assertEquals([], $object->profileImage);
    }

    public function test_get(): void
    {
        $object                          = new Profile();
        $object->name                    = 'testName';
        $object->baptismalName           = 'testBaptismalName';
        $object->birthday                = '2025-01-02';
        $object->currentAssignment       = 'test_0';
        $object->dateOfDeath             = '2025-01-03';
        $object->departureDate           = '2025-01-04';
        $object->entranceDate            = '2025-01-05';
        $object->formerAssignments       = "test_1\r\ntest_2\r\ntest_3";
        $object->initialProfessionDate   = '2025-01-06';
        $object->monasticName            = 'testerMonasticName';
        $object->ordinationDate          = '2025-01-07';
        $object->perpetualProfessionDate = '2025-01-08';
        $object->profileImage            = [];

        $object->save();

        $tester = Profile::get($object->id);
        $this->assertEquals($object->id, $tester->id);
        $this->assertEquals($object->name, $tester->name);
        $this->assertEquals($object->baptismalName, $tester->baptismalName);
        $this->assertEquals($object->birthday, $tester->birthday);
        $this->assertEquals($object->currentAssignment, $tester->currentAssignment);
        $this->assertEquals($object->dateOfDeath, $tester->dateOfDeath);
        $this->assertEquals($object->departureDate, $tester->departureDate);
        $this->assertEquals($object->entranceDate, $tester->entranceDate);
        $this->assertEquals($object->formerAssignments, $tester->formerAssignments);
        $this->assertEquals($object->initialProfessionDate, $tester->initialProfessionDate);
        $this->assertEquals($object->monasticName, $tester->monasticName);
        $this->assertEquals($object->ordinationDate, $tester->ordinationDate);
        $this->assertEquals($object->perpetualProfessionDate, $tester->perpetualProfessionDate);
        $this->assertEquals($object->profileImage, $tester->profileImage);
    }

    public function test_save(): void
    {
        // Insert
        $object                          = new Profile();
        $object->name                    = 'testName';
        $object->baptismalName           = 'testBaptismalName';
        $object->birthday                = '2025-01-02';
        $object->currentAssignment       = 'test_0';
        $object->dateOfDeath             = '2025-01-03';
        $object->departureDate           = '2025-01-04';
        $object->entranceDate            = '2025-01-05';
        $object->formerAssignments       = "test_1\r\ntest_2\r\ntest_3";
        $object->initialProfessionDate   = '2025-01-06';
        $object->monasticName            = 'testerMonasticName';
        $object->ordinationDate          = '2025-01-07';
        $object->perpetualProfessionDate = '2025-01-08';
        $object->profileImage            = [];

        $id = $object->save();
        $this->assertEquals($object->id, $id);
        $this->assertNotEquals(0, $id);

        // Check if the values are saved correctly.
        $post = get_post($id);
        $this->assertEquals('roster_profile', $post->post_type);
        $this->assertEquals('publish', $post->post_status);

        $this->assertEquals($object->name, $post->post_title);
        $this->assertEquals($object->baptismalName, get_post_meta($id, 'roster_baptismal_name', true));
        $this->assertEquals($object->birthday, get_post_meta($id, 'roster_birthday', true));
        $this->assertEquals($object->currentAssignment, get_post_meta($id, 'roster_current_assignment', true));
        $this->assertEquals($object->dateOfDeath, get_post_meta($id, 'roster_date_of_death', true));
        $this->assertEquals($object->departureDate, get_post_meta($id, 'roster_departure_date', true));
        $this->assertEquals($object->entranceDate, get_post_meta($id, 'roster_entrance_date', true));
        $this->assertEquals($object->formerAssignments, get_post_meta($id, 'roster_former_assignments', true));
        $this->assertEquals($object->initialProfessionDate, get_post_meta($id, 'roster_initial_profession_date', true));
        $this->assertEquals($object->monasticName, get_post_meta($id, 'roster_monastic_name', true));
        $this->assertEquals($object->ordinationDate, get_post_meta($id, 'roster_ordination_date', true));
        $this->assertEquals(
            $object->perpetualProfessionDate,
            get_post_meta($id, 'roster_perpetual_profession_date', true),
        );
        $this->assertEquals($object->profileImage, get_post_meta($id, 'roster_profile_image', true));

        // Update
        $object->name                    = 'newTestName';
        $object->baptismalName           = 'newTestBaptismalName';
        $object->birthday                = '2025-02-02';
        $object->currentAssignment       = 'new_test_0';
        $object->dateOfDeath             = '2025-02-03';
        $object->departureDate           = '2025-02-04';
        $object->entranceDate            = '2025-02-05';
        $object->formerAssignments       = "new_test_1\r\nnew_test_2\r\nnew_test_3";
        $object->initialProfessionDate   = '2025-02-06';
        $object->monasticName            = 'testerMonasticName';
        $object->ordinationDate          = '2025-02-07';
        $object->perpetualProfessionDate = '2025-02-08';

        $id = $object->save();

        // Check if the values rellay has been changed.
        $post = get_post($id);
        $this->assertEquals($object->id, $id);
        $this->assertNotEquals(0, $id);

        $this->assertEquals($object->name, $post->post_title);;
        $this->assertEquals($object->baptismalName, get_post_meta($id, 'roster_baptismal_name', true));
        $this->assertEquals($object->birthday, get_post_meta($id, 'roster_birthday', true));
        $this->assertEquals($object->currentAssignment, get_post_meta($id, 'roster_current_assignment', true));
        $this->assertEquals($object->dateOfDeath, get_post_meta($id, 'roster_date_of_death', true));
        $this->assertEquals($object->departureDate, get_post_meta($id, 'roster_departure_date', true));
        $this->assertEquals($object->entranceDate, get_post_meta($id, 'roster_entrance_date', true));
        $this->assertEquals($object->formerAssignments, get_post_meta($id, 'roster_former_assignments', true));
        $this->assertEquals($object->initialProfessionDate, get_post_meta($id, 'roster_initial_profession_date', true));
        $this->assertEquals($object->monasticName, get_post_meta($id, 'roster_monastic_name', true));
        $this->assertEquals($object->ordinationDate, get_post_meta($id, 'roster_ordination_date', true));
        $this->assertEquals(
            $object->perpetualProfessionDate,
            get_post_meta($id, 'roster_perpetual_profession_date', true),
        );
        $this->assertEquals($object->profileImage, get_post_meta($id, 'roster_profile_image', true));
    }
}