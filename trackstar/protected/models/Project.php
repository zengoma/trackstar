<?php

/**
 * This is the model class for table "tbl_project".
 *
 * The followings are the available columns in table 'tbl_project':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class Project extends TrackStarActiveRecord
{
    
    
    /**
	 * Assigns a user, in a specific role, to the project
	 * @param int $userId the primary key for the user
	 * @param string $role the role assigned to the user for the project  	
	 */
	public function assignUser($userId, $role)
	{
		$command = Yii::app()->db->createCommand();
		$command->insert('tbl_project_user_assignment', array(
		    'role'=>$role,
		    'user_id'=>$userId,
		    'project_id'=>$this->id,
		));
	}
       
        /**
	 * Removes a user from being associated with the project
	 * @param int $userId the primary key for the user
	 */
	public function removeUser($userId)
	{
		$command = Yii::app()->db->createCommand();
		$command->delete('tbl_project_user_assignment', 'user_id=:userId AND project_id=:projectId', array(':userId'=>$userId,':projectId'=>$this->id));
	}
        
        /**
	 * Determines whether or not the current application user is in the role for the project
	 * @param string $role the role assigned to the user for the project 
	 * @return boolean whether or not the user is in the role for this project 	
	 */
	public function allowCurrentUser($role)
	{
		$sql = "SELECT * FROM tbl_project_user_assignment WHERE project_id=:projectId AND user_id=:userId AND role=:role";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":projectId", $this->id, PDO::PARAM_INT);
		$command->bindValue(":userId", Yii::app()->user->getId(), PDO::PARAM_INT);
		$command->bindValue(":role", $role, PDO::PARAM_STR);
		return $command->execute()==1 ? true : false;
	}
        
        /**
         * Get a list array of the user role options
         * @return array Html list of available user roles
         */
        
        public function getUserRoleOptions()
        {
            $dataRoles = Yii::app()->authManager->getRoles();
            $listRoles = CHtml::listData($dataRoles, 'name', 'name');
            return $listRoles;
            
        }
        
        /**
         * Check to see if this user is already associated with a project
         * @param integer $user The user Id
         * @return boolean Return true if the user exists, false if not
         */
        
        public function isUserInProject($user)
        {
            $sql = "SELECT * FROM tbl_project_user_assignment WHERE project_id=:projectId AND user_id=:userId";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":projectId", $this->id, PDO::PARAM_INT);
		$command->bindValue(":userId", $user->id, PDO::PARAM_INT);
		return $command->execute()==1;
        }
                
    
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description', 'required'),
			array('create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, create_time, create_user_id, update_time, update_user_id', 'safe', 'on'=>'search'),
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
                    'issues' => array(self::HAS_MANY, 'Issue', 'project_id'),
                    'users' => array(self::MANY_MANY, 'User', 'tbl_project_user_assignment(project_id, user_id)'),
		);
	}
        
        /**
	 * @return array an array listing the users associated with this project
	 */
        public function getUserOptions()
        {
                $usersArray = CHtml::listData($this->users, 'id', 'username');
                $usersArray = CHtml::encodeArray($usersArray);
        
                return $usersArray;
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Project the static model class
	 */
        
         
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
}
