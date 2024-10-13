<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * JobAdvertisements Controller
 *
 * @property \App\Model\Table\JobAdvertisementsTable $JobAdvertisements
 */
class JobAdvertisementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->JobAdvertisements->find();
        $jobAdvertisements = $this->paginate($query);

        $this->set(compact('jobAdvertisements'));
    }

    /**
     * View method
     *
     * @param string|null $id Job Advertisement id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jobAdvertisement = $this->JobAdvertisements->get($id, contain: []);
        $this->set(compact('jobAdvertisement'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jobAdvertisement = $this->JobAdvertisements->newEmptyEntity();
        if ($this->request->is('post')) {
            $jobAdvertisement = $this->JobAdvertisements->patchEntity($jobAdvertisement, $this->request->getData());
            if ($this->JobAdvertisements->save($jobAdvertisement)) {
                $this->Flash->success(__('The job advertisement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The job advertisement could not be saved. Please, try again.'));
        }
        $this->set(compact('jobAdvertisement'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Advertisement id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jobAdvertisement = $this->JobAdvertisements->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobAdvertisement = $this->JobAdvertisements->patchEntity($jobAdvertisement, $this->request->getData());
            if ($this->JobAdvertisements->save($jobAdvertisement)) {
                $this->Flash->success(__('The job advertisement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The job advertisement could not be saved. Please, try again.'));
        }
        $this->set(compact('jobAdvertisement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Advertisement id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobAdvertisement = $this->JobAdvertisements->get($id);
        if ($this->JobAdvertisements->delete($jobAdvertisement)) {
            $this->Flash->success(__('The job advertisement has been deleted.'));
        } else {
            $this->Flash->error(__('The job advertisement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
