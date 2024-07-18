<?php
use PHPUnit\Framework\TestCase;
require_once './src/models/Candidate.php';

class CandidateModelTest extends TestCase {
    private $candidateModel;

    protected function setUp(): void {
        $this->candidateModel = new Candidate();
    }

    public function testCreateCandidate() {

        $userData = [
            'id' => 1,
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'type' => 'candidato',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $userModelMock = $this->createMock(User::class);
        $userModelMock->expects($this->once())
                      ->method('create')
                      ->willReturn(true);

        $this->candidateModel->setUserModel($userModelMock);

        $dataCandidate = [
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

        $result = $this->candidateModel->create($dataCandidate);

        $this->assertTrue($result);
    }

    public function testFindCandidateById() {
        $id = 1;
        $candidate = $this->candidateModel->findById($id);
        $this->assertNotNull($candidate);
        $this->assertEquals($id, $candidate['id']);
    }

}
