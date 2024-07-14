<?php
require_once './Controller.php';
require_once '../models/Job.php';

class JobController extends Controller {
    public function __construct() {
        parent::__construct($this->getModelClass());
    }

    protected function getModelClass() {
        return 'job';
    }

    public function createJob($jobData) {
        $job = new Job($jobData);

        try {
            $job->validate();
            $job->save();
            echo "Job saved successfully.";
        } catch (Exception $e) {
            echo "Failed to save job: " . $e->getMessage();
        }
    }

    public function updateJob($id, array $data) {
        $job = new Job($data);
        try {
            $job->validate();
            $job->update($id);
            echo "Job updated successfully.";
        } catch (Exception $e) {
            echo "Failed to update job: " . $e->getMessage();
        }
    }

    public function deleteJob($id) {
        $job = new Job();
        try {
            $job->delete($id);
            echo "Job deleted successfully.";
        } catch (Exception $e) {
            echo "Failed to delete job: " . $e->getMessage();
        }
    }

    public function deleteMultipleJobs(array $ids) {
        $job = new Job();
        try {
            $job->deleteMultiple($ids);
            echo "Jobs deleted successfully.";
        } catch (Exception $e) {
            echo "Failed to delete jobs: " . $e->getMessage();
        }
    }
}
?>
