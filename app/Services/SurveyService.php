<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SurveyService
{
    public function generateRules(array $schema): array
    {
        return [];

        // TODO: Finish

        $rules = collect();

        if (array_key_exists('validate', $schema)) {
            $rules->put($schema['key'], $this->buildRulesForComponent($schema['validate'] + ['type' => $schema['type']]));
        }

        if (array_key_exists('components', $schema)) {
            foreach ($schema['components'] as $subComponent) {
                $nestedRules = $this->generateRules($subComponent);

                $rules->push($nestedRules);
            }
        }

        return $rules->toArray();
    }

    public function buildRulesForComponent(array $validate): array
    {
        $rules = [];

        foreach ($validate as $key => $value) {
            switch ($key) {
                case 'required':
                    if ($value) {
                        $rules[] = 'required';
                    }
                    break;
                case 'maxLength':
                    $rules[] = 'max:' . $value;
                    break;
                case 'minLength':
                    $rules[] = 'min:' . $value;
                    break;
                case 'type':
                    if ($value === 'email') {
                        //
                    }

                    break;
                default:
                    // handle other cases or ignore
                    break;
            }
        }

        return $rules;
    }

    public function getUser(string $email): User
    {
        $user = User::firstOrCreate([
            'email' => $email,
        ], [
            'name'     => $email,
            'email'    => $email,
            'password' => bcrypt($email),
        ]);

        Auth::login($user);

        return $user;
    }
}