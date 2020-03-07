<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepositoryInterface;
use GuzzleHttp\Psr7\Request;

class UserController extends Controller
{
    protected $userRepositoryInterface;
    
    protected $nbrPerPage = 5;
    
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }
    
    public function index()
    {   
        $users = $this->userRepositoryInterface->getPaginate($this->nbrPerPage);
              
        return $users;
        
    }
    
    public function create()
    {
        //return view('user_create');
    }
    
    public function store(UserCreateRequest $request)
    {
        $this->setAdmin($request);
        
        $user = $this->userRepositoryInterface->store($request->all());
        
        return redirect('user')->with("ok","L'utilisateur " . $user->name . " a été créé.");
    }
    
    public function show($id)
    {
        $user = $this->userRepositoryInterface->getById($id);
        
        return $user;
    }
    
    public function edit($id)
    {
        $user = $this->userRepositoryInterface->getById($id);
        
        return view('user_edit', compact('user'));
        // view('user2_edit', compact('user')) = view('user2_edit', ['user' => $user])
        
    }
    
    public function update(UserUpdateRequest $request, $id)
    {
        $this->setAdmin($request);
        
        $this->userRepositoryInterface->update($id, $request->all());
        
        return redirect('user')->withOk("L'utilisateur " . $request->input('name') . " a été modifié.");
    }
    
    public function destroy($id)
    {
        $this->userRepositoryInterface->destroy($id);
        
        return back();
    }

    
    private function setAdmin($request)
    {
        // admin not sended if not selected
        // need to set a defaylt value
        if(!$request->has('admin'))
        {
            $request->merge(['admin' => 0]);
        }
    }

    public function loginApiGet()
    {        
        $response = 'Call Login Get method from API';
                
        return response($response, 200);
        
    }
    
    
    public function loginApiPost(Request $request)
    {
        $response = 'Call Login Post method from API';
        
        return response($response, 200);
        
        /*$bool = $this->userRepositoryInterface->loginCheck($request->all());
                
        if($bool){
            return response('Auth succeed', 200);
        }else{
            return response('Auth failed', 200);
        }*/
    }
    
}