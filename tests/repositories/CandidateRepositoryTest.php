<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
require_once './src/repositories/CandidateRepository.php';

class CandidateRepositoryTest extends TestCase {
    /**
     * @var CandidateRepository|MockObject
     */
    private $candidateRepository;

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

        $this->candidateRepository = $this->getMockBuilder(CandidateRepository::class)
                                          ->disableOriginalConstructor()
                                          ->getMock();
        $this->candidateRepository->expects($this->any())
                                  ->method('getConnection')
                                  ->willReturn($this->connMock);
    }

    public function testCreate() {
        $data = [
            'user_id' => 1,
            'resume' => 'Experienced software engineer',
            'age' => '27',
            'city' => 'New York',
            'address' => '123 Main St',
            'marital_status' => 'Single',
            'phone' => '555-1234',
        ];
        $fields = 'user_id, resume, age, city, address, marital_status, phone';
        $placeholders = ':user_id, :resume, :age, :city, :address, :marital_status: phone';

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($data);
        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("INSERT INTO candidate_job ($fields) VALUES ($placeholders)")
                       ->willReturn($stmtMock);
        $this->connMock->expects($this->once())
                       ->method('lastInsertId')
                       ->willReturn(1);

        $result = $this->candidateRepository->create($data);
        $this->assertEquals(1, $result);
    }

    public function testUpdate() {
        $data = [
            'user_id' => 1,
            'resume' => 'Experienced software engineer',
            'age' => '27',
            'city' => 'New York',
            'address' => '123 Main St',
            'marital_status' => 'Single',
            'phone' => '555-1234',
        ];
        $id = 1;

        $setClause = 'user_id = :user_id, resume = :resume, age = :age, city = :city, address = :address, marital_status = : marital_status, phone = :phone, updated_at = :updated_at';
        $data['updated_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $data['id'] = $id;

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($data);
        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("UPDATE candidate_job SET $setClause WHERE id = :id")
                       ->willReturn($stmtMock);
        $stmtMock->expects($this->once())
                 ->method('rowCount')
                 ->willReturn(1);

        $result = $this->candidateRepository->update($id, $data);
        $this->assertTrue($result);
    }

    public function testFindById() {
        $id = 1;
        $expectedData = [
            'id' => 1,
            'user_id' => 1,
            'resume' => 'Experienced software engineer',
            'age' => '27',
            'city' => 'New York',
            'address' => '123 Main St',
            'marital_status' => 'Single',
            'phone' => '555-1234'
        ];

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with(['id' => $id]);
        $stmtMock->expects($this->once())
                 ->method('fetch')
                 ->willReturn($expectedData);

        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("SELECT * FROM candidate_job WHERE id = :id")
                       ->willReturn($stmtMock);

        $result = $this->candidateRepository->findById($id);
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
                       ->with("DELETE FROM candidate_job WHERE id = :id")
                       ->willReturn($stmtMock);

        $result = $this->candidateRepository->delete($id);
        $this->assertTrue($result);
    }
}
