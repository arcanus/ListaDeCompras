<?php
namespace entities;

class articulosEntity implements \core\iEntity
{
//--------------------------------PROPIEDADES----------------------------------//
	private $id;
	private $nombre;
	private $is_active;
//-------------------------------------------------------------------------------

//-------------------------------CONSTRUCTORES-----------------------------------
	public function __construct(
		$nombre = null,
		$is_active = true
		)
	{

		$this->setId(null);
		$this->setNombre($nombre);
		$this->setIs_active($is_active);
	}
	//-------------------------------------------------------------------------------

	//-------------------------------GETERS/SETERS-----------------------------------
	public function getId()
	{
		return $this->id;
	}

	public function setId($value)
	{
		$this->id = $value;
	}

	public function getNombre()
	{
		return $this->nombre;
	}

	public function setNombre($value)
	{
		$this->nombre = $value;
	}

	public function getIs_active()
	{
		return $this->is_active;
	}

	public function setIs_active($value)
	{
		$this->is_active = $value;
	}

	//-------------------------------------------------------------------------------

	//---------------------------------METODOS---------------------------------------
	private function validate()
	{
		if (
			isset($this->nombre)
			&& isset($this->is_active)
			)
			{
				return true;
			}
			else
			{
				return false;
			}
	}

	public function insert()
	{
		try
		{
			if ($this->validate())
			{
				$conn = \core\connection::connect();
				$fpdo = new \FluentPDO($conn); 

				$values = array(
					'nombre' => $this->nombre,
					'is_active' => $this->is_active
				);

				$query = $fpdo->insertInto(self::getTableName())->values($values); 
				$resul = $query->execute();

				$query = null;
				$fpdo = null;
				$conn = null;

				$this->id = $resul;

				return true;
			}
			else
			{
				return null;
			}
		} catch (Exception $e) {
			die("ERROR: " . $e->getMessage()); 
		}
	}

	public function delete()
	{
		try
		{
			if (isset($this->id))
			{
				$conn = \core\connection::connect();
				$fpdo = new \FluentPDO($conn); 

				$sql = $fpdo->update(self::getTableName())
										->set(array('is_active' => false))
										->where('id', $this->id);

				$sql->execute();

				$sql = null;
				$fpdo = null;
				$conn = null;

				return true;
			}
			else
			{
				return null;
			}
		} catch (Exception $e) {
			die("ERROR: " . $e->getMessage()); 
		}
	}

	//---------------------------------METODOS ESTATICOS-----------------------------
	public static function getTableName()
	{
		return chop(basename(__FILE__, '.php'), 'Entity');
	}

	public static function getAll()
	{
		try
		{
			$conn = \core\connection::connect();
			$fpdo = new \FluentPDO($conn); 

			$resul = $fpdo->from(self::getTableName())->where('is_active', 1);
			$fpdo = null;
			$conn = null;

			if($resul)
			{
				return $resul->fetchAll();
			}
			else
			{
				return null;
			}
		} catch (Exception $e) {
			die("ERROR: " . $e->getMessage()); 
		}
	}

	public static function getById($id)
	{
		try
		{
			$conn = \core\connection::connect();
			$fpdo = new \FluentPDO($conn); 

			$resul = $fpdo->from(self::getTableName())->where("id = $id AND is_active = true");

			$fpdo = null;
			$conn = null;

			if($resul)
			{
				$db_user = $resul->fetch(); 
				$articulos = new \entities\articulosEntity(); 

				$articulos->setId($db_user['id']); 
				$articulos->setNombre($db_user['nombre']); 
				$articulos->setIs_active($db_user['is_active']); 

				return $articulos;
			}
			else
			{
				return null;
			}
		} catch (Exception $e) {
			die("ERROR: " . $e->getMessage()); 
		}
	}

	public static function deleteById($id)
	{
		try
		{
			if (isset($id))
			{
				$conn = \core\connection::connect();
				$fpdo = new \FluentPDO($conn); 

				$sql = $fpdo->update(self::getTableName())
										->set(array('is_active' => false))
										->where('id', $id);

				$sql->execute();

				$sql = null;
				$fpdo = null;
				$conn = null;

				return true;
			}
			else
			{
				return null;
			}
		} catch (Exception $e) {
			die("ERROR: " . $e->getMessage()); 
		}
	}

}
