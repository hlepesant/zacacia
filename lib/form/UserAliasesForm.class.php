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
			'zarafaAliases'       => new sfWidgetFormSelectCheckbox(array(
                'choices'           => array(),
                'formatter'         => array($this, 'zFormatter'),
                'label_separator'   => '</div><div ym-g33 ym-gl>',
            )),
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

    public function zFormatter($widget, $inputs)
    {
        $rows = array();
        $i=0;
        foreach ($inputs as $input)
        {
            $color = sprintf('za-%s', (($i%2)==0) ? 'odd' : 'even');

            $rows[] = $widget->renderContentTag(
                'div',
                $input['label'].'</div><div class="ym-g20 ym-gl za-liner '.$color.'">'.$input['input'],
                array('class' => 'ym-g75 ym-gl za-line '.$color)
            );
            $i++;
        }

        return $widget->renderContentTag('div', implode($widget->getOption('separator'), $rows), array('class' => 'ym-grid'));
    }
}
