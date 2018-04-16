<?php

use Library\Import;
use PHPUnit\Framework\TestCase;

class ImportTest extends TestCase
{
    public function testDetectTypeFalse(): void
    {
        $result = new Import([
            [
                'id'=>0,
                'first_name'=>'James',
                'last_name'=>'Monroe',
                'email_address'=>'jmonroe@whitehouse.gov',
                'group_id'=>1,
                'state'=>'VA'
            ]
        ]);

        $this->assertFalse($result->type);
    }

    public function testDetectTypePerson(): void
    {
        $result = new Import([
            [
                'person_id'=>1,
                'first_name'=>'James',
                'last_name'=>'Monroe',
                'email_address'=>'jmonroe@whitehouse.gov',
                'group_id'=>1,
                'state'=>'VA'
            ]
        ]);

        $this->assertEquals($result->type, 'Person');
    }

    public function testDetectTypeGroup(): void
    {
        $result = new Import([
            [
                'group_id'=>1,
                'group_name'=>'Presidents'
            ]
        ]);

        $this->assertEquals($result->type, 'Group');
    }

    public function testProcessInvalidCsv(): void
    {
        $this->expectException(Exception::class);

        $result = new Import([
            [
                'id'=>0,
                'first_name'=>'James',
                'last_name'=>'Monroe',
                'email_address'=>'jmonroe@whitehouse.gov',
                'group_id'=>1,
                'state'=>'VA'
            ]
        ]);

        $result->process();

    }
}
