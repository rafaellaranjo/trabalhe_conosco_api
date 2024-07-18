<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
require_once './src/repositories/CandidateJobRepository.php';

class CandidateJobRepositoryTest extends TestCase {
    /**
     * @var CandidateJobRepository|MockObject
     */
    private $candidateJobRepository;

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

        $this->candidateJobRepository = $this->getMockBuilder(CandidateJobRepository::class)
                                             ->disableOriginalConstructor()
                                             ->getMock();
        $this->candidateJobRepository->expects($this->any())
                                     ->method('getConnection')
                                     ->willReturn($this->connMock);
    }

    public function testCreate() {
        $data = [
            'job_id' => 1,
            'candidate_id' => 1,
            'status' => 'applied'
        ];
        $fields = 'job_id, candidate_id, status';
        $placeholders = ':job_id, :candidate_id, :status';

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($data);
        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("INSERT INTO candidate ($fields) VALUES ($placeholders)")
                       ->willReturn($stmtMock);
        $this->connMock->expects($this->once())
                       ->method('lastInsertId')
                       ->willReturn(1);

        $result = $this->candidateJobRepository->create($data);
        $this->assertEquals(1, $result);
    }

    public function testUpdate() {
        $data = [
            'job_id' => 1,
            'candidate_id' => 1,
            'status' => 'applied'
        ];
        $id = 1;

        $setClause = 'job_id = :job_id, candidate_id = :candidate_id, updated_at = :updated_at, status = :status';
        $data['updated_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $data['id'] = $id;

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($data);
        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("UPDATE candidate SET $setClause WHERE id = :id")
                       ->willReturn($stmtMock);
        $stmtMock->expects($this->once())
                 ->method('rowCount')
                 ->willReturn(1);

        $result = $this->candidateJobRepository->update($id, $data);
        $this->assertTrue($result);
    }

    public function testFindById() {
        $id = 1;
        $expectedData = [
            'id' => 1,
            'job_id' => 1,
            'candidate_id' => 1,
            'status' => 'applied'
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
                       ->with("SELECT * FROM candidate WHERE id = :id")
                       ->willReturn($stmtMock);

        $result = $this->candidateJobRepository->findById($id);
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
                       ->with("DELETE FROM candidate WHERE id = :id")
                       ->willReturn($stmtMock);

        $result = $this->candidateJobRepository->delete($id);
        $this->assertTrue($result);
    }

}
