<?php
return array(
	array(
		'url'=>'users/api_users/login',
		'method'=>'POST',
		'action'=>'This action for identifie a user and start a session with token',
		'params'=>array(
			array(
		    	"name"=>"username",
		    	"description"=>"username is integer input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"password",
		    	"description"=>"password is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"client_id",
		    	"description"=>"client_id is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"client_secret",
		    	"description"=>"client_secret is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
		),
		"success_response"=>array(
			"success"=>"true",
			"message"=>"Some summary message",
			"data"=>array(
				"id" => "integer",
		    	"email" => "string",
		    	"name" => "string",
		    	"lastname" => "string",
		    	"username" => "string",
		    	"state" => "integer",
		    	"state_email" => "integer",
		    	"img" => "string",
		    	"registered" => "string",
		    	"papelera" => "integer",
		    	"phone" => "integer",
		    	"address" => "string",
		    	"birthdate" => "date YYYY-MM-DD",
		    	"token" => array(
		    		'access_token'=> "J6J8FyHcavE2zXQAXyvncAYDSHcVGMjubfjja_5w",
					'token_refresh'=> "bsf4FcnduOaYDUT4of0H25gkH6rMydU2FEDKsvCkzzHxRvJA7qT3X5S2y_db",
					'token_type'=> "Bearer",
					'expires_in'=> 86400,
					'scope'=> "grant",
	    		),
			)
		),
		"error_response"=>array(
		    "error"=> "A key (e.g. no_found) for the error",
		    "error_description"=> "A longer description of the error."
		),
	),

	// ....
	array(
		'url'=>'users/api_users/update_profile',
		'method'=>'POST',
		'action'=>'Update current users',
		'params'=>array(
			array(
		    	"name"=>"newPassword",
		    	"description"=>"password is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"email",
		    	"description"=>"email is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"name",
		    	"description"=>"name is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"lastname",
		    	"description"=>"lastname is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"img",
		    	"description"=>"img is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"phone",
		    	"description"=>"phone is integer input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"address",
		    	"description"=>"address is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"birthdate",
		    	"description"=>"birthdate is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
		),
		"success_response"=>array(
			"success"=>"true",
			"message"=>"Some summary message",
			"data"=>array(
		    "id" => "integer",
		    "password" => "string",
		    "email" => "string",
		    "name" => "string",
		    "lastname" => "string",
		    "username" => "string",
		    "state" => "integer",
		    "state_email" => "integer",
		    "img" => "string",
		    "registered" => "string",
		    "papelera" => "integer",
		    "phone" => "integer",
		    "address" => "string",
			)
		),
		"error_response"=>array(
		    "error"=> "no_save",
		    "error_description"=> "Validations errors",
		    "data"=> array(
			"password"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"email"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"name"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"lastname"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"username"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"state"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"state_email"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"img"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"registered"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"papelera"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"phone"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"address"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
		    ),
		),
	),
	
	// ....
	array(
		'url'=>'users/api_users/register',
		'method'=>'POST',
		'action'=>'Create a new Users and send a email for activate this new account',
		'params'=>array(
			array(
		    	"name"=>"client_id",
		    	"description"=>"client_id is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),	
			array(
		    	"name"=>"client_secret",
		    	"description"=>"client_secret is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),	
			array(
		    	"name"=>"password",
		    	"description"=>"password is string input type is required just if {sendPassword} module user parameter value is false",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"email",
		    	"description"=>"email is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"name",
		    	"description"=>"name is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"lastname",
		    	"description"=>"lastname is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"conditions",
		    	"description"=>"conditions is Boolean 0/1 input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"phone",
		    	"description"=>"phone is integer input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"address",
		    	"description"=>"address is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"birthdate",
		    	"description"=>"is date YYYY-MM-DD input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
		),
		"success_response"=>array(
			"success"=>"true",
			"message"=>"Some summary message",
			"data"=>array(
		    "id" => "integer",
		    "password" => "string",
		    "email" => "string",
		    "name" => "string",
		    "lastname" => "string",
		    "username" => "string",
		    "state" => "integer",
		    "state_email" => "integer",
		    "img" => "string",
		    "registered" => "string",
		    "papelera" => "integer",
		    "phone" => "integer",
		    "address" => "string",
		    "birthdate" => "date YYYY-MM-DD",
			)
		),
		"error_response"=>array(
		    "error"=> "no_save",
		    "error_description"=> "Validations errors",
		    "data"=> array(
			"password"=>array(
					"Reason error eg. Nombre no puede ser nulo.",
			),
			"email"=>array(
					"Reason error eg. Nombre no puede ser nulo.",
			),
			"name"=>array(
					"Reason error eg. Nombre no puede ser nulo.",
			),
			"lastname"=>array(
					"Reason error eg. Nombre no puede ser nulo.",
			),
			"username"=>array(
					"Reason error eg. Nombre no puede ser nulo.",
			),
		    ),
		),
	),// ....
	array(
		'url'=>'users/api_users/forgot',
		'method'=>'POST',
		'action'=>'Reset password and send to users email',
		'params'=>array(
			array(
		    	"name"=>"email",
		    	"description"=>"email is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
		),
		"success_response"=>array(
			"success"=>"true",
			"message"=>"Email has been sent ",
			"data"=>null
		),
		"error_response"=>array(
		    "error"=> "no_save",
		    "error_description"=> "Validations errors",
		    "data"=> array(
				"email"=>array(
						"Reason error eg. Nombre no puede ser nulo o no esta registrado.",
				),
		  ),
		),
	),
	// ...			
	array(
		'url'=>'users/api_users/me',
		'method'=>'GET',
		'action'=>'This action retrive datails about current user',
		'params'=>array(
		),
		"success_response"=>array(
			"success"=>"true",
			"message"=>"Some summary message",
			"data"=>array(
				"id" => "integer",
		    	"email" => "string",
		    	"name" => "string",
		    	"lastname" => "string",
		    	"username" => "string",
		    	"state" => "integer",
		    	"state_email" => "integer",
		    	"img" => "string",
		    	"registered" => "string",
		    	"papelera" => "integer",
		    	"phone" => "integer",
		    	"address" => "string",
			)
		),
		"error_response"=>array(
		    "error"=> "A key (e.g. no_found) for the error",
		    "error_description"=> "A longer description of the error."
		),
	),
	array(
		'url'=>'users/api_users/',
		'method'=>'GET',
		'action'=>'This action retrive all Users resources, you can also filter according to sended params.',
		'params'=>array(
			array(
		    	"name"=>"id",
		    	"description"=>"id is integer input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"password",
		    	"description"=>"password is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"email",
		    	"description"=>"email is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"name",
		    	"description"=>"name is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"lastname",
		    	"description"=>"lastname is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"username",
		    	"description"=>"username is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"state",
		    	"description"=>"state is integer input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"state_email",
		    	"description"=>"state_email is integer input type",
		    	"defaultValue"=>0,
				"required"=>false,
			),
			array(
		    	"name"=>"img",
		    	"description"=>"img is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"registered",
		    	"description"=>"registered is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"papelera",
		    	"description"=>"papelera is integer input type",
		    	"defaultValue"=>0,
				"required"=>false,
			),
			array(
		    	"name"=>"phone",
		    	"description"=>"phone is integer input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"address",
		    	"description"=>"address is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
		),
		"success_response"=>array(
			"success"=>"true",
			"message"=>"Some summary message",
			"data"=>array(
			array(
		    	"id" => "integer",
		    	"password" => "string",
		    	"email" => "string",
		    	"name" => "string",
		    	"lastname" => "string",
		    	"username" => "string",
		    	"state" => "integer",
		    	"state_email" => "integer",
		    	"img" => "string",
		    	"registered" => "string",
		    	"papelera" => "integer",
		    	"phone" => "integer",
		    	"address" => "string",
				),array(
			    "id" => "integer",
			    "password" => "string",
			    "email" => "string",
			    "name" => "string",
			    "lastname" => "string",
			    "username" => "string",
			    "state" => "integer",
			    "state_email" => "integer",
			    "img" => "string",
			    "registered" => "string",
			    "papelera" => "integer",
			    "phone" => "integer",
			    "address" => "string",
			),
		)
		),
		"error_response"=>array(
		    "error"=> "A key (e.g. no_found) for the error",
		    "error_description"=> "A longer description of the error."
		),
	),
	// ....	
	array(
		'url'=>'users/api_users/view/{id}',
		'method'=>'GET',
		'action'=>'This action retrive a Users selected.',
		'params'=>array(),
		"success_response"=>array(
			"success"=>"true",
			"message"=>"Some summary message",
			"data"=>array(
		    "id" => "integer",
		    "password" => "string",
		    "email" => "string",
		    "name" => "string",
		    "lastname" => "string",
		    "username" => "string",
		    "state" => "integer",
		    "state_email" => "integer",
		    "img" => "string",
		    "registered" => "string",
		    "papelera" => "integer",
		    "phone" => "integer",
		    "address" => "string",
		    "birthdate" => "date YYYY-MM-DD",
			)
		),
		"error_response"=>array(
		    "error"=> "A key (e.g. no_found) for the error",
		    "error_description"=> "A longer description of the error."
		),
	),
	// ....
	array(
		'url'=>'users/api_users/update/{id}',
		'method'=>'POST',
		'action'=>'Update a Users',
		'params'=>array(
			array(
		    	"name"=>"password",
		    	"description"=>"password is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"email",
		    	"description"=>"email is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"name",
		    	"description"=>"name is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"lastname",
		    	"description"=>"lastname is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"username",
		    	"description"=>"username is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"state",
		    	"description"=>"state is integer input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"state_email",
		    	"description"=>"state_email is integer input type",
		    	"defaultValue"=>0,
				"required"=>false,
			),
			array(
		    	"name"=>"img",
		    	"description"=>"img is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"registered",
		    	"description"=>"registered is string input type",
		    	"defaultValue"=>null,
				"required"=>true,
			),
			array(
		    	"name"=>"papelera",
		    	"description"=>"papelera is integer input type",
		    	"defaultValue"=>0,
				"required"=>false,
			),
			array(
		    	"name"=>"phone",
		    	"description"=>"phone is integer input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
			array(
		    	"name"=>"address",
		    	"description"=>"address is string input type",
		    	"defaultValue"=>null,
				"required"=>false,
			),
		),
		"success_response"=>array(
			"success"=>"true",
			"message"=>"Some summary message",
			"data"=>array(
		    "id" => "integer",
		    "password" => "string",
		    "email" => "string",
		    "name" => "string",
		    "lastname" => "string",
		    "username" => "string",
		    "state" => "integer",
		    "state_email" => "integer",
		    "img" => "string",
		    "registered" => "string",
		    "papelera" => "integer",
		    "phone" => "integer",
		    "address" => "string",
			)
		),
		"error_response"=>array(
		    "error"=> "no_save",
		    "error_description"=> "Validations errors",
		    "data"=> array(
			"password"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"email"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"name"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"lastname"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"username"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"state"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"state_email"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"img"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"registered"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"papelera"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"phone"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
			"address"=>array(
				array(
					"Reason error eg. Nombre no puede ser nulo.",
					"Reason 2 error eg. numer value is required.",
				)
			),
		    ),
		),
	),
);