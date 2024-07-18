<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
require_once './src/repositories/JobRepository.php';

class JobRepositoryTest extends TestCase {
    /**
     * @var JobRepository|MockObject
     */
    private $jobRepository;

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

        $this->jobRepository = $this->getMockBuilder(JobRepository::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();
        $this->jobRepository->expects($this->any())
                            ->method('getConnection')
                            ->willReturn($this->connMock);
    }

    public function testCreate() {
        $data = [
            'title' => 'Desenvolvedor PHP',
            'description' => 'Desenvolvimento de aplicações web em PHP.',
            'hiring_model' => HiringModel::CLT->value,
            'requirements' => 'Conhecimento em PHP, MySQL, Docker.',
            'benefits' => 'Plano de saúde, vale alimentação.',
            'salary' => '5000',
            'status' => 'open'
        ];
        $fields = 'title, description, hiring_model, requirements, benefits, salary, status';
        $placeholders = ':title, :description, :hiring_model, :requirements, :benefits, :salary, :status';

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($data);
        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("INSERT INTO jobs ($fields) VALUES ($placeholders)")
                       ->willReturn($stmtMock);
        $this->connMock->expects($this->once())
                       ->method('lastInsertId')
                       ->willReturn(1);

        $result = $this->jobRepository->create($data);
        $this->assertEquals(1, $result);
    }

    public function testUpdate() {
        $data = [
            'title' => 'Desenvolvedor PHP',
            'description' => 'Desenvolvimento de aplicações web em PHP.',
            'hiring_model' => HiringModel::CLT->value,
            'requirements' => 'Conhecimento em PHP, MySQL, Docker.',
            'benefits' => 'Plano de saúde, vale alimentação.',
            'salary' => '5000',
            'status' => 'open'
        ];
        $id = 1;

        $setClause = 'name = :name, email = :email, updated_at = :updated_at, password = :password, type = :type';
        $setClause = 'title = :title, description = :description, hiring_model = :hiring_model, requirements = :requirements, benefits = :benefits, salary = :salary, status = :status, updated_at = :updated_at';
        $data['updated_at'] = (new DateTime())->format('Y-m-d H:i:s');
        $data['id'] = $id;

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($data);
        $this->connMock->expects($this->once())
                       ->method('prepare')
                       ->with("UPDATE jobs SET $setClause WHERE id = :id")
                       ->willReturn($stmtMock);
        $stmtMock->expects($this->once())
                 ->method('rowCount')
                 ->willReturn(1);

        $result = $this->jobRepository->update($id, $data);
        $this->assertTrue($result);
    }

    public function testFindById() {
        $id = 1;
        $expectedData = [
            'id' => 1,
            'title' => 'Desenvolvedor PHP',
            'description' => 'Desenvolvimento de aplicações web em PHP.',
            'hiring_model' => HiringModel::CLT->value,
            'requirements' => 'Conhecimento em PHP, MySQL, Docker.',
            'benefits' => 'Plano de saúde, vale alimentação.',
            'salary' => '5000',
            'status' => 'open'
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
                       ->with("SELECT * FROM jobs WHERE id = :id")
                       ->willReturn($stmtMock);

        $result = $this->jobRepository->findById($id);
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
                       ->with("DELETE FROM jobs WHERE id = :id")
                       ->willReturn($stmtMock);

        $result = $this->jobRepository->delete($id);
        $this->assertTrue($result);
    }

}
