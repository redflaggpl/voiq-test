<?php
/**
 * CDataColumn class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CDataColumn represents a grid view column that is associated with a data attribute or PHP expression.
 *
 * Either {@link name} or {@link value} should be specified. The former specifies
 * a data attribute name, while the latter a PHP expression whose value should be rendered instead.
 *
 * The property {@link sortable} determines whether the grid view can be sorted according to this column.
 * Note that the {@link name} should always be set if the column needs to be sortable. The {@link name}
 * value will be used by {@link CSort} to render a clickable link in the header cell to trigger the sorting.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package zii.widgets.grid
 * @since 1.1
 */
class CFilterDataColumn extends CDataColumn
{

	/**
	 * Renders the filter cell content.
	 * This method will render the {@link filter} as is if it is a string.
	 * If {@link filter} is an array, it is assumed to be a list of options, and a dropdown selector will be rendered.
	 * Otherwise if {@link filter} is not false, a text field is rendered.
	 * @since 1.1.1
	 */
	protected function renderFilterCellContent()
	{
		if(is_string($this->filter))
			echo $this->filter;
		elseif($this->filter!==false && $this->grid->filter!==null && $this->name!==null && strpos($this->name,'.')===false)
		{
			if(is_array($this->filter))
				echo CHtml::activeDropDownList($this->grid->filter, $this->name, $this->filter, array('id'=>false,'prompt'=>'','class'=>'form-control'));
			elseif($this->filter===null)
				echo CHtml::activeTextField($this->grid->filter, $this->name, array('id'=>false,'class'=>'form-control'));
		}
		else
			parent::renderFilterCellContent();
	}
}
