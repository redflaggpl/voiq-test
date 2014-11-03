<?php
/**
 * This is the model class for table "users_users".
 *
 * The followings are the available columns in table 'users_users':
 * @property integer $id
 * @property string $password
 * @property string $email
 * @property string $name
 * @property string $lastname
 * @property string $username
 * @property integer $state
 * @property integer $state_email
 * @property string $img
 * @property string $registered
 */
class Users extends CActiveRecord
{
	public $conditions=0;
	public $newPassword;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password, email, name, lastname, username, state, registered', 'required'),
			array('state, state_email', 'numerical', 'integerOnly'=>true),
			array('password, email', 'length', 'max'=>128),
			array('password, newPassword', 'length', 'min'=>4),
			array('name, lastname, username, img', 'length', 'max'=>255),
			array('email', 'email'),
			array('papelera, phone, address', 'safe'),
			array('birthdate', 'date', 'format'=>'yyyy-M-d'),
			array('email', 'unique', 'attributeName'=>'email', 'className'=>'Users', 'criteria'=>array('condition'=>'papelera=0')),
			// array('email', 'unique', 'attributeName'=>'email', 'className'=>'Users', 'criteria'=>array('condition'=>'papelera=0 AND state_email=1 AND state=1')),
			// array('phone, address', 'required', 'on'=>'signup'),
			array('conditions', 'boolean'),
			array('newPassword, mobile, users_address_country_id, users_address_state_id, users_address_city_id, gender, card_identity', 'safe'),
			array('conditions', 'in','range'=>array('1'),'allowEmpty'=>false,'message'=>'Para registrarse debe aceptar los terminos y condiciones','on'=>'signup'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, password, email, birthdate, name, lastname, username, state, state_email, img, registered, mobile, users_address_country_id, users_address_state_id, users_address_city_id, gender, card_identity', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'tokens'=>array(self::HAS_MANY,'AccessTokens','users_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'password' => Yii::t('app','Password'),
			'email' => Yii::t('app','Email'),
			'name' => Yii::t('app','Name'),
			'lastname' => Yii::t('app','Lastname'),
			'username' => Yii::t('app','Username'),
			'state' => Yii::t('app','State'),
			'state_email' => Yii::t('app','State Email'),
			'img' => Yii::t('app','Img'),
			'registered' => Yii::t('app','Registered'),
			'conditions' => Yii::t('app','I accept terms and conditions.'),
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('state_email',$this->state_email);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('registered',$this->registered,true);
		$criteria->compare('papelera',0);
		$criteria->addCondition("username<>'root'");
		$criteria->order="id DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getFullname()
	{
		return $this->name." ".$this->lastname;
	}

	public function getImageUrl()
	{
		if(!empty($this->img))
		{
			if(strpos($this->img,"http")===0)
				return $this->img;
			return Yii::app()->request->baseUrl."/uploads/".$this->img;
		}
		else
			return Yii::app()->request->baseUrl."/img/icon-user-default.png";
	}

	public function getImageObject()
	{
		return CHtml::image($this->getImageUrl(),"",array(
				"class"=>"img-responsive img-circle",
				"style"=>"width:40px",
			));
	}

	/**
	 * statusEditable
	 * Para poder editar en lónea un campo 
	 * en este cso el campo state que
	 * dice el estado del usuario si este campo esta en
	 * 0 el usuario no puede ingresar al sistema
	 * @return un string con un link  
	*/
	public function statusEditable($url)
	{

		$label=$this->state==1?"Activo":"Inactivo";
		$source=array("1"=>"Activo","2"=>"Inactivo");

		return Yii::app()->editable->select($label, $source, array(
			"data-name"=>"state",
			"data-value"=>$this->state,
			"data-url"=>$url,
			"data-pk"=>$this->id,
			"data-title"=>"Estado",
		));
	}

	public function login()
	{
		$identity=new UserIdentity($this->email,$this->password);
		$identity->authenticateFree();
		// @todo si es mobile ponerlo siempre logueado
		$duration=3600*24*30; // 30 days
		Yii::app()->user->login($identity,$duration);
	}

	public function findByToken($token)
	{
		return self::model()->find(array(
			'with'=>array('tokens'),
			'condition'=>'tokens.acces_token=?',
			'params'=>array($token),
		));
	}

	public function findByBasic($token)
	{
		$user=explode(':',base64_decode($token));
		if(!isset($user[1]))
			return null;
		return self::model()->find(array(
			'condition'=>'(username=? OR email=?) AND password=?',
			'params'=>array($user[0],$user[0],sha1($user[1])),
		));
	}

	public function getAccessToken($model)
	{
		$code=new CodeAuth;
		$code->users_id=Yii::app()->user->id;
		$code->code=Yii::app()->security->randomWord(40);
		$code->created_at=date('Y-m-d H:i:s');
		$code->save();

		$token=new AccessTokens;
		$token->acces_token=Yii::app()->security->randomWord(40);
		$token->acces_token_refresh=Yii::app()->security->randomWord(60);
		$token->apps_id=$model->id;
		$token->users_id=$this->id;
		$token->code=$code->code;
		
		if($token->save())
			return array(
				'access_token'=>$token->acces_token,
				'token_refresh'=>$token->acces_token_refresh,
				'token_type'=>'Bearer',
				'expires_in'=>86400,
				'scope'=>'grant',
			);	
		else
			return null;
	}

	public function check($roles=null)
	{
		if($roles===null)
			return true;
		
		$args=func_get_args();
		if($args!==array() and count($args)>1)
			$roles=$args;
		
		if(is_array($roles))
		{
			foreach($roles as $role)
				if(Yii::app()->authManager->checkAccess($role,$this->id)) return true;
		}
		else if(is_string($roles))
			return Yii::app()->authManager->checkAccess($roles,$this->id);
		return false;
	}

	public static function listData()
	{
		return CHtml::listData(self::model()->findAll('papelera=?',array(0)),'id','fullname');
	}
}
