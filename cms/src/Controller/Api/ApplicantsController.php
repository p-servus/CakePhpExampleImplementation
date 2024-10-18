<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Entity\Applicant;
use Authentication\Controller\Component\AuthenticationComponent;
use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Utility\Security;
use Cake\View\JsonView;

/**
 * Applicants Controller
 *
 * @property \App\Model\Table\ApplicantsTable $Applicants
 * 
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class ApplicantsController extends AppController
{
    protected array $paginate = [
        'limit' => 5,
        'order' => [
            'Applicants.id' => 'asc',
        ],
    ];

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->authorize($this->Applicants->newEmptyEntity());

        $query = $this->Applicants->find('all');
        $applicants = $query->all();

        //TODO: pagination for the API?
        // $applicants = $this->paginate($query);

        $this->set(compact('applicants'));
        $this->viewBuilder()->setOption('serialize', ['applicants']);
    }

    /**
     * View method
     *
     * @param string|null $id Applicant id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $applicant = $this->Applicants->get($id);

        $this->Authorization->authorize($applicant);

        $this->set(compact('applicant'));
        $this->viewBuilder()->setOption('serialize', ['applicant']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post', 'put']);
        
        $applicant = $this->Applicants->newEntity($this->request->getData());

        $this->Authorization->authorize($applicant);

        if ($this->Applicants->save($applicant)) {
            $status  = 'OK';
            $message = 'The applicant has been saved.';
        } else {
            $applicant = null;

            $status  = 'Error';
            $message = 'The applicant could not be saved. Please, try again.';
        }

        $this->set(compact('applicant', 'status', 'message'));
        $this->viewBuilder()->setOption('serialize', ['applicant', 'status', 'message']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Applicant id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        $applicant = $this->Applicants->get($id, contain: []);

        $this->Authorization->authorize($applicant);
        
        $applicant = $this->Applicants->patchEntity($applicant, $this->request->getData());

        if ($this->Applicants->save($applicant)) {
            $status  = 'OK';
            $message = 'The applicant has been saved.';
        } else {
            $applicant = null;

            $status  = 'Error';
            $message = 'The applicant could not be saved. Please, try again.';
        }

        $this->set(compact('applicant', 'status', 'message'));
        $this->viewBuilder()->setOption('serialize', ['applicant', 'status', 'message']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Applicant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);

        $applicant = $this->Applicants->get($id);

        $this->Authorization->authorize($applicant);

        if ($this->Applicants->delete($applicant)) {
            $status  = 'OK';
            $message = 'The applicant has been deleted.';
        } else {
            $applicant = null;

            $status  = 'Error';
            $message = 'The applicant could not be deleted. Please, try again.';
        }

        $this->set(compact('status', 'message'));
        $this->viewBuilder()->setOption('serialize', ['status', 'message']);
    }
}
