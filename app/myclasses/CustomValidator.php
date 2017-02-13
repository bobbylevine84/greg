<?php

use Illuminate\Validation\Validator as Validator;

class CustomValidator extends Validator {

    // validates 5-digit U.S. postal codes, and the ZIP+4 format.
    public function validateZip($attribute, $value, $parameters) {
        return preg_match('/^[0-9]{5}(\-[0-9]{4})?$/', $value);
    }

    // validates allowed feature validations
    public function validateAllowed($attribute, $value, $parameters) {

		$this->requireParameterCount(1, $parameters, 'allowed');

		$value = trim($value);
		if(empty($value)) return true;

		$allowed = $parameters[0];
		$allowed_parts = explode("-", $allowed);

		$value_parts = explode("|", $value);

		foreach($value_parts as $vp) {

			$vp = $this->startSubstr($vp);

			if(!in_array($vp, $allowed_parts)) return false;
		}

        return true;
    }

    // validates dependent <field> has value
    public function validateRequires($attribute, $value, $parameters) {

		$this->requireParameterCount(1, $parameters, 'requires');

        return $this->validateRequired($parameters[0], $this->getValue($parameters[0]));
    }

    // validates less than <field> value
    public function validateLessthan($attribute, $value, $parameters) {

		$this->requireParameterCount(1, $parameters, 'lessthan');

        return $value < $this->getValue($parameters[0]);
    }

    // validates greater than <field> value
    public function validateGreaterthan($attribute, $value, $parameters) {

//pr($attribute);
//pr($this->rules[$attribute], 1);
//pr($this->getValue($parameters[0]), 1);

		$this->requireParameterCount(1, $parameters, 'greaterthan');

        return $value > $this->getValue($parameters[0]);
    }





    // validates ip type less than <field> value
    public function validateLessthaneqip($attribute, $value, $parameters) {

		$this->requireParameterCount(1, $parameters, 'lessthaneqip');

		$vLastOctet = $this->getLastOctet($value);

		$pLastOctet = $this->getLastOctet($this->getValue($parameters[0]));

        return $vLastOctet <= $pLastOctet;

    }

    // validates ip type greater than <field> value
    public function validateGreaterthaneqip($attribute, $value, $parameters) {

		$this->requireParameterCount(1, $parameters, 'greaterthaneqip');

		$vLastOctet = $this->getLastOctet($value);

		$pLastOctet = $this->getLastOctet($this->getValue($parameters[0]));

        return $vLastOctet >= $pLastOctet;
    }


	// validates distinct
	// parameters legend:
	// 0 - model
	// 1 - field type
	// 2 - field
	// 3 - field 2 for range
	// 4 - escape id
	// 5 - id column
	public function validateDistinct($attribute, $value, $parameters) {

		$this->requireParameterCount(3, $parameters, 'distinct');

		return $this->getDistinct($attribute, $value, $parameters);
	}

	// validates distinct ip
	// parameters legend:
	// 0 - model
	// 1 - field type
	// 2 - field
	// 3 - field 2 for range
	// 4 - escape id
	// 5 - id column
	public function validateDistinctip($attribute, $value, $parameters) {

		$this->requireParameterCount(3, $parameters, 'distinctip');

		$value = sprintf("%u", ip2long($value));

		return $this->getDistinct($attribute, $value, $parameters);
	}

	// validates distinct range
	// parameters legend:
	// 0 - model
	// 1 - field type
	// 2 - field
	// 3 - field 2 for range
	// 4 - escape id
	// 5 - id column
	public function validateDistinctrange($attribute, $value, $parameters) {

		$this->requireParameterCount(4, $parameters, 'distinctrange');

		return $this->getDistinct($attribute, $value, $parameters);
	}

	// validates distinct ip range
	// parameters legend:
	// 0 - model
	// 1 - field type
	// 2 - field
	// 3 - field 2 for range
	// 4 - escape id
	// 5 - id column
	public function validateDistinctiprange($attribute, $value, $parameters) {
		$this->requireParameterCount(4, $parameters, 'distinctiprange');

		$value = sprintf("%u", ip2long($value));

		return $this->getDistinct($attribute, $value, $parameters);
	}












	// CUSTOM HELPER FUNCTIONS
	// get string from start upto first occurence of character
	public function startSubstr($s,$sep=':') {
		$pos = strpos($s, $sep);
		if($pos) return substr($s, 0, $pos);
		return $s;
	}

	// parameters legend:
	// 0 - model
	// 1 - field type
	// 2 - field
	// 3 - field 2 for range
	// 4 - escape id
	// 5 - id column
	public function getDistinct($attribute, $value, $parameters) {

// echo $attribute . ' - ' . $value;
// pr($parameters);

		$model = new $parameters[0]();

		$fType = isset($parameters[1]) ? $parameters[1] : null;
		$fType = strtolower($fType) == 'null' ? null : $fType;

		$fld1 = isset($parameters[2]) ? $parameters[2] : null;
		$fld1 = strtolower($fld1) == 'null' ? null : $fld1;

		$fld2 = isset($parameters[3]) ? $parameters[3] : null;
		$fld2 = strtolower($fld2) == 'null' ? null : $fld2;

		$id = isset($parameters[4]) ? $parameters[4] : null;
		$id = strtolower($id) == 'null' ? null : $id;

		$idCol = isset($parameters[5]) ? $parameters[5] : '_id';

		if($fType) $model = $model->where('ft_type', '=', $fType);

		if($fld2) $model = $model->where($fld1, '<=', $value)->where($fld2, '>=', $value);
		else if($fld1) $model = $model->where($fld1, '=', $value);

		if($id) $model = $model->where($idCol, '<>', $id);

		$kount = $model->count();
		//$kount = $model->get()->toArray();

//pr($kount);

		return $kount <= 0;
	}


	protected function getLastOctet($value) {
		$octets = explode('.', $value);
		return end($octets);
	}

	protected function getDisplayableFiledName($fieldname) {
		return ucwords(str_replace( ['_', '.'] , [' ', ' '], $fieldname));
	}

	protected function requireAllDependantFields($parameters, $rule) {
		foreach($parameters as $p) {
			if(!$this->validateRequired($p, $this->getValue($p)))
				throw new \InvalidArgumentException("Validation rule $rule requires " . $this->getDisplayableFiledName($p) . ".");
		}
	}

    // REPLACEMENTS FOR VALIDATION MESSAGES
	protected function replaceRequires($message, $attribute, $rule, $parameters) {
		return str_replace(':field', $this->getAttribute($parameters[0]), $message);
	}

	protected function replaceLessthan($message, $attribute, $rule, $parameters) {
		return str_replace(':value', $this->getValue($parameters[0]), $message);
	}

	protected function replaceGreaterthan($message, $attribute, $rule, $parameters) {
		return str_replace(':value', $this->getValue($parameters[0]), $message);
	}

	protected function replaceLessthaneqip($message, $attribute, $rule, $parameters) {
		$value = $this->getValue($parameters[0]);
		return str_replace(':value', $this->getLastOctet($value), $message);
	}

	protected function replaceGreaterthaneqip($message, $attribute, $rule, $parameters) {
		$value = $this->getValue($parameters[0]);
		return str_replace(':value', $this->getLastOctet($value), $message);
	}
}