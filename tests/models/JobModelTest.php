<?php
use PHPUnit\Framework\TestCase;
require_once './src/models/Job.php';

class JobModelTest extends TestCase {
    private $jobModel;

    protected function setUp(): void {
        $this->jobModel = new Job();
    }

    public function testCreateJob() {
        $data = [
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

        $result = $this->jobModel->create($data);
        $this->assertTrue($result);
    }

    public function testFindJobById() {
        $id = 1;
        $job = $this->jobModel->findById($id);
        $this->assertNotNull($job);
        $this->assertEquals($id, $job['id']);
    }

}
