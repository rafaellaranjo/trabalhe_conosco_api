<?php
use PHPUnit\Framework\TestCase;
require_once './src/models/CandidateJob.php';

class CandidateModelTest extends TestCase {
    private $candidateJobModel;

    protected function setUp(): void {
        $this->candidateJobModel = new CandidateJob();
    }

    public function testCreateCandidate() {
        $jobData = [
            'id' => 1,
            'title' => 'Desenvolvedor PHP',
            'description' => 'Desenvolvimento de aplicações web em PHP.',
            'hiring_model' => HiringModel::CLT->value,
            'requirements' => 'Conhecimento em PHP, MySQL, Docker.',
            'benefits' => 'Plano de saúde, vale alimentação.',
            'salary' => '5000',
            'status' => 'open',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $userData = [
            'id' => 1,
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'type' => 'candidato',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $candidateData = [
            'id' => 1,
            'user_id' => $userData['id'],
            'resume' => 'Experienced software engineer',
            'age' => '27',
            'city' => 'New York',
            'address' => '123 Main St',
            'marital_status' => 'Single',
            'phone' => '555-1234',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $jobModelMock = $this->createMock(Job::class);
        $jobModelMock->expects($this->once())
                    ->method('create')
                    ->willReturn(true);

        $userModelMock = $this->createMock(User::class);
        $userModelMock->expects($this->once())
                      ->method('create')
                      ->willReturn(true);

        $CandidateModelMock = $this->createMock(User::class);
        $CandidateModelMock->expects($this->once())
                      ->method('create')
                      ->willReturn(true);

        $this->candidateJobModel->setJobModel($jobModelMock);
        $this->candidateJobModel->setUserModel($userModelMock);
        $this->candidateJobModel->setCandidateModel($CandidateModelMock);

        $data = [
            'job_id' => $jobData['id'],
            'candidate_id' => $candidateData['id'],
            'status' => 'applied',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->candidateJobModel->create($data);
        $this->assertTrue($result);
    }

    public function testFindCandidateJobById() {
        $id = 1;
        $candidateJob = $this->candidateJobModel->findById($id);
        $this->assertNotNull($candidateJob);
        $this->assertEquals($id, $candidateJob['id']);
    }

}
