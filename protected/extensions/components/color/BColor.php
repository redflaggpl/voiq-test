<?php

class BColor extends CApplicationComponent
{
	public $colors=array(
			"#0D4A8B",
			"#8c0d4a",
			"#4a8c0d",
			"#9d261d",
			"#c3325f",
			"#7a43b6",
			"#7a43b6",
			"#b57a43",
			"#43b57a",
			"#a64646",
			"#4646a6",
			"#a32c06",
			"#A54B46",
			"#75781d",
			"#771c74",
			"#466CA5",
			"#5F46A5",
			"#9CA546",
			"#006ea6",
			"#0D4A8B",
			"#676767",
			"#3aa8db",
			"#A54D46",
			"#A54676",
			"#6D46A5",
			"#465EA5",
			"#4699A5",
			"#A5A546",
			"#A54694",
		);

	public function rand()
	{
		return $this->colors[rand(0,count($this->colors)-1)];
	}
}