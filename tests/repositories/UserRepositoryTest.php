<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
require_once './src/repositories/UserRepository.php';

class UserRepositoryTest extends TestCase {
    /**
     * @var UserRepository|MockObject
     */
    private $userRepository;

    /**
     * @var MockObject
     */
    private $dbMock;

    /**
     * @var MockObject
     */
    private $connMock;

    protected function setUp(): void {
        $this->dbMock = $this->createMock(Database::class);
        $this->connMock = $this->createMock(PDO::class);

        $this->dbMock->method('getConnection')->willReturn($this->connMock);

        $this->userRepository = $this->getMockBuilder(UserRepository::class)
                                     ->disableOriginalConstructor()
                                     ->getMock();
        $this->userRepository->expects($this->any())
                             ->method('getConnection')
                             ->willReturn($this->connMock);
    }

    public function testLoginSuccess() {
        $username = 'testuser';
        $password = 'password123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userId = 1;

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with([$username]);
        $stmtMock->expects($this->once())
                 ->method('fetch')
                 ->willReturn([
                     'id' => $userId,
                     'username' => $username,
                     'password' => $hashedPassword
                 ]);

        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with('SELECT * FROM user WHERE username = ?')
                       ->willReturn($stmtMock);

        $result = $this->userRepository->signin($username, $password);
        $this->assertEquals($userId, $result);
    }

    public function testLoginFailure() {
        $username = 'testuser';
        $password = 'wrongpassword';

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with([$username]);
        $stmtMock->expects($this->once())
                 ->method('fetch')
                 ->willReturn(false);

        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with('SELECT * FROM user WHERE username = ?')
                       ->willReturn($stmtMock);

        $result = $this->userRepository->signin($username, $password);
        $this->assertFalse($result);
    }

    public function testCreate() {
        $data = ['name' => 'Test', 'email' => 'test@example.com', 'password' => 'password123', 'type' => 'candidato'];
        $fields = 'name, email, password, type';
        $placeholders = ':name, :email, :password, :type';

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($data);
        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("INSERT INTO user ($fields) VALUES ($placeholders)")
                       ->willReturn($stmtMock);
        $this->connMock->expects($this->once())
                       ->method('lastInsertId')
                       ->willReturn(1);

        $result = $this->userRepository->create($data);
        $this->assertEquals(1, $result);
    }

    public function testUpdate() {
        $data = ['name' => 'Test', 'email' => 'test@example.com', 'password' => 'password123', 'type' => 'candidato'];
        $id = 1;

        $setClause = 'name = :name, email = :email, updated_at = :updated_at, password = :password, type = :type';
        $data['updated_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $data['id'] = $id;

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($data);
        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("UPDATE user SET $setClause WHERE id = :id")
                       ->willReturn($stmtMock);
        $stmtMock->expects($this->once())
                 ->method('rowCount')
                 ->willReturn(1);

        $result = $this->userRepository->update($id, $data);
        $this->assertTrue($result);
    }

    public function testFindById() {
        $id = 1;
        $expectedData = ['id' => 1, 'name' => 'Test', 'email' => 'test@example.com', 'password' => 'password123', 'type' => 'candidato'];

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with(['id' => $id]);
        $stmtMock->expects($this->once())
                 ->method('fetch')
                 ->willReturn($expectedData);

        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("SELECT * FROM user WHERE id = :id")
                       ->willReturn($stmtMock);

        $result = $this->userRepository->findById($id);
        $this->assertEquals($expectedData, $result);
    }

    public function testDelete() {
        $id = 1;

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with(['id' => $id]);
        $stmtMock->expects($this->once())
                 ->method('rowCount')
                 ->willReturn(1);

        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("DELETE FROM user WHERE id = :id")
                       ->willReturn($stmtMock);

        $result = $this->userRepository->delete($id);
        $this->assertTrue($result);
    }
}