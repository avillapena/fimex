<?php

namespace frontend\models\certificados;

use Yii;

/**
 * This is the model class for table "Empleados".
 *
 * @property integer $IdEmpleado
 * @property integer $Nomina
 * @property string $ApellidoPaterno
 * @property string $ApellidoMaterno
 * @property string $Nombre
 * @property integer $IdEmpleadoEstatus
 * @property string $RFC
 * @property string $IMSS
 * @property integer $IdDepartamento
 * @property integer $IdTurno
 * @property integer $IdPuesto
 *
 * @property Temperaturas[] $temperaturas
 * @property TratamientosTermicos[] $tratamientosTermicos
 * @property TiemposMuerto[] $tiemposMuertos
 * @property User[] $users
 * @property Departamentos $idDepartamento
 * @property EmpleadosEstatus $idEmpleadoEstatus
 * @property Programaciones[] $programaciones
 * @property Inventarios[] $inventarios
 * @property Producciones[] $producciones
 * @property ProgramacionesAlma[] $programacionesAlmas
 * @property EmpleadoDepartamento[] $empleadoDepartamentos
 * @property Responsables[] $responsables
 */
class Empleados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Empleados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Nomina'], 'required'],
            [['Nomina', 'IdEmpleadoEstatus', 'IdDepartamento', 'IdTurno', 'IdPuesto'], 'integer'],
            [['ApellidoPaterno', 'ApellidoMaterno', 'Nombre', 'RFC', 'IMSS'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdEmpleado' => 'Id Empleado',
            'Nomina' => 'Nomina',
            'ApellidoPaterno' => 'Apellido Paterno',
            'ApellidoMaterno' => 'Apellido Materno',
            'Nombre' => 'Nombre',
            'IdEmpleadoEstatus' => 'Id Empleado Estatus',
            'RFC' => 'Rfc',
            'IMSS' => 'Imss',
            'IdDepartamento' => 'Id Departamento',
            'IdTurno' => 'Id Turno',
            'IdPuesto' => 'Id Puesto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemperaturas()
    {
        return $this->hasMany(Temperaturas::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTratamientosTermicos()
    {
        return $this->hasMany(TratamientosTermicos::className(), ['idSuperviso' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTiemposMuertos()
    {
        return $this->hasMany(TiemposMuerto::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDepartamento()
    {
        return $this->hasOne(Departamentos::className(), ['IdDepartamento' => 'IdDepartamento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEmpleadoEstatus()
    {
        return $this->hasOne(EmpleadosEstatus::className(), ['IdEmpleadoEstatus' => 'IdEmpleadoEstatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramaciones()
    {
        return $this->hasMany(Programaciones::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInventarios()
    {
        return $this->hasMany(Inventarios::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducciones()
    {
        return $this->hasMany(Producciones::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgramacionesAlmas()
    {
        return $this->hasMany(ProgramacionesAlma::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleadoDepartamentos()
    {
        return $this->hasMany(EmpleadoDepartamento::className(), ['IdEmpleado' => 'IdEmpleado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsables()
    {
        return $this->hasMany(Responsables::className(), ['IdEmpleado' => 'IdEmpleado']);
    }
}
