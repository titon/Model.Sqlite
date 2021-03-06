<?php
namespace Titon\Db\Sqlite;

use Titon\Common\Config;
use Titon\Test\Stub\Repository\Stat;
use Titon\Test\Stub\Repository\User;

class DriverTest extends \Titon\Db\Driver\PdoDriverTest {

    protected function setUp() {
        $this->object = new SqliteDriver(Config::get('db'));
        $this->object->connect();

        $this->table = new User();
    }

    public function testDescribeTable() {
        $this->loadFixtures(['Users', 'Stats']);

        $user = new User();
        $this->assertEquals([
            'id' => [
                'field' => 'id',
                'type' => 'integer',
                'length' => '',
                'null' => false,
                'default' => '',
                'primary' => true,
                'ai' => true
            ],
            'country_id' => [
                'field' => 'country_id',
                'type' => 'integer',
                'length' => '',
                'null' => true,
                'default' => null
            ],
            'username' => [
                'field' => 'username',
                'type' => 'varchar',
                'length' => '255',
                'null' => true,
                'default' => null
            ],
            'password' => [
                'field' => 'password',
                'type' => 'varchar',
                'length' => '255',
                'null' => true,
                'default' => null
            ],
            'email' => [
                'field' => 'email',
                'type' => 'varchar',
                'length' => '255',
                'null' => true,
                'default' => null
            ],
            'firstName' => [
                'field' => 'firstName',
                'type' => 'varchar',
                'length' => '255',
                'null' => true,
                'default' => null
            ],
            'lastName' => [
                'field' => 'lastName',
                'type' => 'varchar',
                'length' => '255',
                'null' => true,
                'default' => null
            ],
            'age' => [
                'field' => 'age',
                'type' => 'smallint',
                'length' => '',
                'null' => true,
                'default' => null
            ],
            'created' => [
                'field' => 'created',
                'type' => 'datetime',
                'length' => '',
                'null' => true,
                'default' => null
            ],
            'modified' => [
                'field' => 'modified',
                'type' => 'datetime',
                'length' => '',
                'null' => true,
                'default' => null
            ],
        ], $user->getDriver()->describeTable($user->getTable()));

        $stat = new Stat();
        $this->assertEquals([
            'id' => [
                'field' => 'id',
                'type' => 'integer',
                'length' => '',
                'null' => false,
                'default' => null,
                'primary' => true,
                'ai' => true
            ],
            'name' => [
                'field' => 'name',
                'type' => 'varchar',
                'length' => '255',
                'null' => true,
                'default' => null
            ],
            'health' => [
                'field' => 'health',
                'type' => 'integer',
                'length' => '',
                'null' => true,
                'default' => null
            ],
            'energy' => [
                'field' => 'energy',
                'type' => 'smallint',
                'length' => '',
                'null' => true,
                'default' => null
            ],
            'damage' => [
                'field' => 'damage',
                'type' => 'float',
                'length' => '',
                'null' => true,
                'default' => null
            ],
            'defense' => [
                'field' => 'defense',
                'type' => 'double',
                'length' => '',
                'null' => true,
                'default' => null
            ],
            'range' => [
                'field' => 'range',
                'type' => 'decimal',
                'length' => '8,2',
                'null' => true,
                'default' => null
            ],
            'isMelee' => [
                'field' => 'isMelee',
                'type' => 'boolean',
                'length' => '',
                'null' => true,
                'default' => null
            ],
            'data' => [
                'field' => 'data',
                'type' => 'blob',
                'length' => '',
                'null' => true,
                'default' => null
            ],
        ], $user->getDriver()->describeTable($stat->getTable()));
    }

    public function testGetDsn() {
        $this->assertEquals('sqlite:', $this->object->getDsn());

        $this->object->setConfig('memory', true);
        $this->assertEquals('sqlite::memory:', $this->object->getDsn());

        $this->object->setConfig('path', '/path/to/sql.db');
        $this->assertEquals('sqlite:/path/to/sql.db', $this->object->getDsn());

        $this->object->setConfig('dsn', 'custom:dsn');
        $this->assertEquals('custom:dsn', $this->object->getDsn());
    }

}