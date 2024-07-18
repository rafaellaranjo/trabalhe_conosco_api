<?php
use PHPUnit\Framework\TestCase;
require_once './src/models/User.php';

class UserModelTest extends TestCase {
    private $userModel;

    protected function setUp(): void {
        $this->userModel = new User();
    }

    public function testCreateUser() {
        $data = [
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'type' => 'candidato',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->userModel->create($data);
        $this->assertTrue($result);
    }

    public function testFindJobById() {
        $id = 1;
        $user = $this->userModel->findById($id);
        $this->assertNotNull($user);
        $this->assertEquals($id, $user['id']);
    }

}
