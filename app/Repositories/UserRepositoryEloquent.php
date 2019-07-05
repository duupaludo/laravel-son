<?php

namespace App\Repositories;

use Jrean\UserVerification\Facades\UserVerification;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\User;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{

    public function create(array $attributes)
    {
        $attributes['role'] = User::ROLE_ADMIN;
        $attributes['password'] = User::generatePassword();
        $model = parent::create($attributes);
        UserVerification::generate($model);
        UserVerification::send(
            $model,
            'Bem vindo ao app XXXX'
        );
        return $model;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
