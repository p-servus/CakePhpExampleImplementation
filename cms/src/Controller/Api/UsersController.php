<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Model\Entity\User;
use Authentication\Controller\Component\AuthenticationComponent;
use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Utility\Security;
use Cake\View\JsonView;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * 
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class UsersController extends AppController
{
    protected array $paginate = [
        'limit' => 5,
        'order' => [
            'Users.id' => 'asc',
        ],
    ];

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['add']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $query = $this->Users->find('all');
        $users = $query->all();
        //TODO: pagination for the API?
        // $users = $this->paginate($query);
        $this->set(compact('users'));
        $this->viewBuilder()->setOption('serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $this->Authorization->authorize($user);
        $this->set(compact('user'));
        $this->viewBuilder()->setOption('serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post', 'put']);
        
        $this->Authorization->skipAuthorization();
        
        $user = $this->Users->newEntity($this->request->getData(), [
            // Enable modification of password.
            // Enable modification of token.
            // Disable modification of isAdmin. (defauts to false)
            'accessibleFields' => [
                'password' => true,
                'token'    => true,
                'isAdmin'  => false,
            ],
        ]);

        $newToken = User::NewToken();
        $user->token = $newToken;

        if ($this->Users->save($user)) {
            $status  = 'OK';
            $message = 'The user has been saved.';
        } else {
            $user = null;
            $newToken = null;

            $status  = 'Error';
            $message = 'The user could not be saved. Please, try again.';
        }

        $this->set(compact('user', 'newToken', 'status', 'message'));
        $this->viewBuilder()->setOption('serialize', ['user', 'newToken', 'status', 'message']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        $user = $this->Users->get($id, contain: []);

        $this->Authorization->authorize($user);
        
        $user = $this->Users->patchEntity($user, $this->request->getData(), [
            // Disable modification of password.
            // Disable modification of token.
            // Disable modification of isAdmin.
            'accessibleFields' => [
                'password' => false,
                'token'    => false,
                'isAdmin'  => false,
            ],
        ]);

        if ($this->Users->save($user)) {
            $status  = 'OK';
            $message = 'The user has been saved.';
        } else {
            $user = null;

            $status  = 'Error';
            $message = 'The user could not be saved. Please, try again.';
        }

        $this->set(compact('user', 'status', 'message'));
        $this->viewBuilder()->setOption('serialize', ['user', 'status', 'message']);
    }

    /**
     * Edit Password method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editPassword($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        $user = $this->Users->get($id, contain: []);

        $this->Authorization->authorize($user);
        
        $user = $this->Users->patchEntity($user, $this->request->getData(), [
            // Whitelist only modification of password.
            'fieldList' => [
                'password',
            ],
            'accessibleFields' => [
                'password' => true,
            ],
        ]);

        if ($this->Users->save($user)) {
            $status  = 'OK';
            $message = 'The password has been saved.';
        } else {
            $user = null;

            $status  = 'Error';
            $message = 'The password could not be saved. Please, try again.';
        }

        $this->set(compact('status', 'message'));
        $this->viewBuilder()->setOption('serialize', ['status', 'message']);
    }

    /**
     * Edit Token method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editToken($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        $user = $this->Users->get($id, contain: []);

        $this->Authorization->authorize($user);
        
        $user = $this->Users->patchEntity($user, $this->request->getData(), [
            // Whitelist only modification of token.
            'fieldList' => [
                'token',
            ],
            'accessibleFields' => [
                'token' => true,
            ],
        ]);

        $newToken = User::NewToken();
        $hint     = 'Please store this token in a safe location!!! Because of security reasons, only a hash of it will be stored here! If you lost the token, you have to create a new one!';
        $user->token = $newToken;

        if ($this->Users->save($user)) {
            $status  = 'OK';
            $message = 'The token has been saved.';
        } else {
            $user     = null;
            $newToken = null;
            $hint     = null;

            $status  = 'Error';
            $message = 'The token could not be saved. Please, try again.';
        }

        $this->set(compact('newToken', 'hint', 'status', 'message'));
        $this->viewBuilder()->setOption('serialize', ['newToken', 'hint', 'status', 'message']);
    }

    /**
     * Edit Permissions method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editPermissions($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        $user = $this->Users->get($id, contain: []);

        $this->Authorization->authorize($user);
        
        $user = $this->Users->patchEntity($user, $this->request->getData(), [
            // Whitelist only modification of isAdmin.
            'fieldList' => [
                'isAdmin',
            ],
            'accessibleFields' => [
                'isAdmin' => true,
            ],
        ]);

        if ($this->Users->save($user)) {
            $status  = 'OK';
            $message = 'The permissions has been saved.';
        } else {
            $user = null;

            $status  = 'Error';
            $message = 'The permissions could not be saved. Please, try again.';
        }

        $this->set(compact('user', 'status', 'message'));
        $this->viewBuilder()->setOption('serialize', ['user', 'status', 'message']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);

        $user = $this->Users->get($id);

        $this->Authorization->authorize($user);

        if ($this->Users->delete($user)) {
            $status  = 'OK';
            $message = 'The user has been deleted.';
        } else {
            $user = null;

            $status  = 'Error';
            $message = 'The user could not be deleted. Please, try again.';
        }

        $this->set(compact('status', 'message'));
        $this->viewBuilder()->setOption('serialize', ['status', 'message']);
    }
}
