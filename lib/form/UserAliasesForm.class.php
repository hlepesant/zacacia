<?php
class UserAliasesForm extends ZacaciaForm
{
	public function configure()
	{
		$this->setWidgets(array(
			'platformDn'          => new sfWidgetFormInputHidden(),
			'companyDn'           => new sfWidgetFormInputHidden(),
			'userDn'              => new sfWidgetFormInputHidden(),
			'selectAll'           => new sfWidgetFormInputCheckbox(),
			'zarafaAliases'       => new sfWidgetFormSelectCheckbox(array('choices' => array())),
			'mail'                => new sfWidgetFormInputText(),
            'domain'              => new sfWidgetFormSelect(array('choices' => array())),
            'zarafaAlias'         => new sfWidgetFormInputHidden(),
		));
	      
		$this->widgetSchema->setLabels(array(
			'selectAll'           => 'Select All',
			'zarafaAliases'       => 'Enabled Alias',
			'mail'                => 'New Alias',
		));

		$this->setValidators(array(
			'platformDn'          => new sfValidatorString(),
			'companyDn'           => new sfValidatorString(),
			'userDn'              => new sfValidatorString(),
			'zarafaAliases'       => new sfValidatorCallback(array(
				'callback' => array($this, 'aliasValidator')
			)),
            'mail'                => new sfValidatorString(),
            'domain'              => new sfValidatorString(),
		 	'zarafaAlias'         => new sfValidatorEmail(),
		));
    
		$this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
		$this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
	}

	public function aliasValidator($validator, $aliases)
	{
		$alias_validator = new sfValidatorEmail();
		try {
			foreach($aliases as $alias) {
				$alias_validator->clean($alias);
			}
		}
		catch(sfValidatorError $e) {
		}
	}
}
