<?php


$r= $_GET['r'];
	$year = date('Y');
	$month = date('m');
	$day = date('d');
	$day2 = ($day + 1);
	$day3 = ($day + 2);    
	$day4 = ($day + 3);    
	$day5 = ($day + 4);      
	$day6 = ($day + 5);      
	$day7 = ($day + 6);      
	$day8 = ($day + 7);
	$day9 = ($day + 8);    
	$day10 = ($day + 9);    
	$day11 = ($day + 10);      
	$day12 = ($day + 11);      
	$day13 = ($day + 12);      
  	echo json_encode(array(
	
		array(
			'id' => 111,
			'title' => "Event1",
			'start' => "$year-$month-$day",
			'url' => "http://google.com/",
            'resourceId' => 1
		),    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day}T08:00:00Z",
			'end' => "$year-$month-${day}T09:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,

		
		array(
			'id' => 222,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day}T09:00:00Z",
			'end' => "$year-$month-${day}T10:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),

    	array(
			'id' => 222,
			'title' => "8 $r Available",
			'start' => "$year-$month-${day}T10:00:00Z",
			'end' => "$year-$month-${day}T11:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day}&time=10:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),
    
        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day}T11:00:00Z",
			'end' => "$year-$month-${day}T12:00:00Z",
            'allDay' => false,
           
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,
    
      array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day}T12:00:00Z",
			'end' => "$year-$month-${day}T13:00:00Z",
            'allDay' => false, 
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,


        array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day}T13:00:00Z",
			'end' => "$year-$month-${day}T14:00:00Z",
            'allDay' => false,     'url' => "add.php?date=$year-$month-${day}&time=13:00",
            'resourceId' => 3 ,
            'color'=>'#006633'
		)        ,

        array(
			'id' => 333,
			'title' => "6 $r Available",
			'start' => "$year-$month-${day}T14:00:00Z",
			'end' => "$year-$month-${day}T15:00:00Z",'url' => "add.php?date=$year-$month-${day}&time=14:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day}T15:00:00Z",
			'end' => "$year-$month-${day}T16:00:00Z",  'url' => "add.php?date=$year-$month-${day}&time=15:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) 
    
    
    ,

        array(
			'id' => 333,
			'title' => "2 $r Available",
			'start' => "$year-$month-${day}T16:00:00Z",
			'end' => "$year-$month-${day}T17:00:00Z",   'url' => "add.php?date=$year-$month-${day}&time=16:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,

        array(
			'id' => 333,
			'title' => "4 $r Available",
			'start' => "$year-$month-${day}T17:00:00Z",
			'end' => "$year-$month-${day}T18:00:00Z", 'url' => "add.php?date=$year-$month-${day}&time=17:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		)     ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day}T18:00:00Z",
			'end' => "$year-$month-${day}T19:00:00Z", 'url' => "add.php?date=$year-$month-${day}&time=18:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day}T19:00:00Z",
			'end' => "$year-$month-${day}T20:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day}T20:00:00Z",
			'end' => "$year-$month-${day}T21:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,
        array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day2}T08:00:00Z",
			'end' => "$year-$month-${day2}T09:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,

		
		array(
			'id' => 222,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day2}T09:00:00Z",
			'end' => "$year-$month-${day2}T10:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day2}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),

    	array(
			'id' => 222,
			'title' => "8 $r Available",
			'start' => "$year-$month-${day2}T10:00:00Z",
			'end' => "$year-$month-${day2}T11:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day}&time=10:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),
    
        array(
			'id' => 333,
			'title' => "4 $r Available",
			'start' => "$year-$month-${day2}T11:00:00Z",
			'end' => "$year-$month-${day2}T12:00:00Z",
            'allDay' => false,
           
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,
    
      array(
			'id' => 333,
			'title' => "6 $r Available",
			'start' => "$year-$month-${day2}T12:00:00Z",
			'end' => "$year-$month-${day2}T13:00:00Z",
            'allDay' => false, 
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,


        array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day2}T13:00:00Z",
			'end' => "$year-$month-${day2}T14:00:00Z",
            'allDay' => false,     'url' => "add.php?date=$year-$month-${day2}&time=13:00",
            'resourceId' => 3 ,
            'color'=>'#006633'
		)        ,

        array(
			'id' => 333,
			'title' => "6 $r Available",
			'start' => "$year-$month-${day2}T14:00:00Z",
			'end' => "$year-$month-${day2}T15:00:00Z",'url' => "add.php?date=$year-$month-${day2}&time=14:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "5 $r Available",
			'start' => "$year-$month-${day2}T15:00:00Z",
			'end' => "$year-$month-${day2}T16:00:00Z",  'url' => "add.php?date=$year-$month-${day2}&time=15:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) 
    
    
    ,

        array(
			'id' => 333,
			'title' => "2 $r Available",
			'start' => "$year-$month-${day2}T16:00:00Z",
			'end' => "$year-$month-${day2}T17:00:00Z",   'url' => "add.php?date=$year-$month-${day2}&time=16:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,

        array(
			'id' => 333,
			'title' => "4 $r Available",
			'start' => "$year-$month-${day2}T17:00:00Z",
			'end' => "$year-$month-${day2}T18:00:00Z", 'url' => "add.php?date=$year-$month-${day2}&time=17:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		)     ,    array(
			'id' => 333,
			'title' => "8 $r Available",
			'start' => "$year-$month-${day2}T18:00:00Z",
			'end' => "$year-$month-${day2}T19:00:00Z", 'url' => "add.php?date=$year-$month-${day2}&time=18:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "7 $r Available",
			'start' => "$year-$month-${day2}T19:00:00Z",
			'end' => "$year-$month-${day2}T20:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day2}T20:00:00Z",
			'end' => "$year-$month-${day2}T21:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,
        array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day3}T08:00:00Z",
			'end' => "$year-$month-${day3}T09:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,

		
		array(
			'id' => 222,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day3}T09:00:00Z",
			'end' => "$year-$month-${day3}T10:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day3}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),

    	array(
			'id' => 222,
			'title' => "8 $r Available",
			'start' => "$year-$month-${day3}T10:00:00Z",
			'end' => "$year-$month-${day3}T11:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day3}&time=10:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),
    
        array(
			'id' => 333,
			'title' => "4 $r Available",
			'start' => "$year-$month-${day3}T11:00:00Z",
			'end' => "$year-$month-${day3}T12:00:00Z",
            'allDay' => false,
           
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,
    
      array(
			'id' => 333,
			'title' => "6 $r Available",
			'start' => "$year-$month-${day3}T12:00:00Z",
			'end' => "$year-$month-${day3}T13:00:00Z",
            'allDay' => false, 
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,


        array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day3}T13:00:00Z",
			'end' => "$year-$month-${day3}T14:00:00Z",
            'allDay' => false,     'url' => "add.php?date=$year-$month-${day3}&time=13:00",
            'resourceId' => 3 ,
            'color'=>'#006633'
		)        ,

        array(
			'id' => 333,
			'title' => "6 $r Available",
			'start' => "$year-$month-${day3}T14:00:00Z",
			'end' => "$year-$month-${day3}T15:00:00Z",'url' => "add.php?date=$year-$month-${day3}&time=14:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "5 $r Available",
			'start' => "$year-$month-${day3}T15:00:00Z",
			'end' => "$year-$month-${day3}T16:00:00Z",  'url' => "add.php?date=$year-$month-${day3}&time=15:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) 
    
    
    ,

        array(
			'id' => 333,
			'title' => "2 $r Available",
			'start' => "$year-$month-${day3}T16:00:00Z",
			'end' => "$year-$month-${day3}T17:00:00Z",   'url' => "add.php?date=$year-$month-${day3}&time=16:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,

        array(
			'id' => 333,
			'title' => "4 $r Available",
			'start' => "$year-$month-${day3}T17:00:00Z",
			'end' => "$year-$month-${day3}T18:00:00Z", 'url' => "add.php?date=$year-$month-${day3}&time=17:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		)     ,    array(
			'id' => 333,
			'title' => "8 $r Available",
			'start' => "$year-$month-${day3}T18:00:00Z",
			'end' => "$year-$month-${day3}T19:00:00Z", 'url' => "add.php?date=$year-$month-${day3}&time=18:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "7 $r Available",
			'start' => "$year-$month-${day3}T19:00:00Z",
			'end' => "$year-$month-${day3}T20:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day3}T20:00:00Z",
			'end' => "$year-$month-${day3}T21:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) 
	   ,
        	array(
			'id' => 222,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day4}T08:00:00Z",
			'end' => "$year-$month-${day4}T09:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day4}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),

		
		array(
			'id' => 222,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day4}T09:00:00Z",
			'end' => "$year-$month-${day4}T10:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day4}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),

    	array(
			'id' => 222,
			'title' => "8 $r Available",
			'start' => "$year-$month-${day4}T10:00:00Z",
			'end' => "$year-$month-${day4}T11:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day4}&time=10:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),
    
        array(
			'id' => 333,
			'title' => "4 $r Available",
			'start' => "$year-$month-${day4}T11:00:00Z",
			'end' => "$year-$month-${day4}T12:00:00Z",
            'allDay' => false,
           
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,
    
      array(
			'id' => 333,
			'title' => "6 $r Available",
			'start' => "$year-$month-${day4}T12:00:00Z",
			'end' => "$year-$month-${day4}T13:00:00Z",
            'allDay' => false, 
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,


        array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day4}T13:00:00Z",
			'end' => "$year-$month-${day4}T14:00:00Z",
            'allDay' => false,     'url' => "add.php?date=$year-$month-${day4}&time=13:00",
            'resourceId' => 3 ,
            'color'=>'#006633'
		)        ,

        array(
			'id' => 333,
			'title' => "6 $r Available",
			'start' => "$year-$month-${day4}T14:00:00Z",
			'end' => "$year-$month-${day4}T15:00:00Z",'url' => "add.php?date=$year-$month-${day4}&time=14:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "5 $r Available",
			'start' => "$year-$month-${day4}T15:00:00Z",
			'end' => "$year-$month-${day4}T16:00:00Z",  'url' => "add.php?date=$year-$month-${day4}&time=15:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) 
    
    
    ,

        array(
			'id' => 333,
			'title' => "2 $r Available",
			'start' => "$year-$month-${day4}T16:00:00Z",
			'end' => "$year-$month-${day4}T17:00:00Z",   'url' => "add.php?date=$year-$month-${day4}&time=16:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,

        array(
			'id' => 333,
			'title' => "4 $r Available",
			'start' => "$year-$month-${day4}T17:00:00Z",
			'end' => "$year-$month-${day4}T18:00:00Z", 'url' => "add.php?date=$year-$month-${day4}&time=17:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		)     ,    array(
			'id' => 333,
			'title' => "8 $r Available",
			'start' => "$year-$month-${day4}T18:00:00Z",
			'end' => "$year-$month-${day4}T19:00:00Z", 'url' => "add.php?date=$year-$month-${day4}&time=18:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "7 $r Available",
			'start' => "$year-$month-${day4}T19:00:00Z",
			'end' => "$year-$month-${day4}T20:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day4}T20:00:00Z",
			'end' => "$year-$month-${day4}T21:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,

		
		array(
			'id' => 222,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day5}T08:00:00Z",
			'end' => "$year-$month-${day5}T09:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day5}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),

		array(
			'id' => 222,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day5}T09:00:00Z",
			'end' => "$year-$month-${day5}T10:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day5}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),

    	array(
			'id' => 222,
			'title' => "8 $r Available",
			'start' => "$year-$month-${day5}T10:00:00Z",
			'end' => "$year-$month-${day5}T11:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day5}&time=10:00",
            'resourceId' => 2       ,
            'color'=>'#006633'
		),
    
        array(
			'id' => 333,
			'title' => "4 $r Available",
			'start' => "$year-$month-${day5}T11:00:00Z",
			'end' => "$year-$month-${day5}T12:00:00Z",
            'allDay' => false,
           
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,
    
      array(
			'id' => 333,
			'title' => "6 $r Available",
			'start' => "$year-$month-${day5}T12:00:00Z",
			'end' => "$year-$month-${day5}T13:00:00Z",
            'allDay' => false, 
            'resourceId' => 3 ,
            'color'=>'#006633'
		)  ,


        array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day5}T13:00:00Z",
			'end' => "$year-$month-${day5}T14:00:00Z",
            'allDay' => false,     'url' => "add.php?date=$year-$month-${day5}&time=13:00",
            'resourceId' => 3 ,
            'color'=>'#006633'
		)        ,

        array(
			'id' => 333,
			'title' => "6 $r Available",
			'start' => "$year-$month-${day5}T14:00:00Z",
			'end' => "$year-$month-${day5}T15:00:00Z",'url' => "add.php?date=$year-$month-${day5}&time=14:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "5 $r Available",
			'start' => "$year-$month-${day5}T15:00:00Z",
			'end' => "$year-$month-${day5}T16:00:00Z",  'url' => "add.php?date=$year-$month-${day5}&time=15:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) 
    
    
    ,

        array(
			'id' => 333,
			'title' => "2 $r Available",
			'start' => "$year-$month-${day5}T16:00:00Z",
			'end' => "$year-$month-${day5}T17:00:00Z",   'url' => "add.php?date=$year-$month-${day5}&time=16:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,

        array(
			'id' => 333,
			'title' => "4 $r Available",
			'start' => "$year-$month-${day5}T17:00:00Z",
			'end' => "$year-$month-${day5}T18:00:00Z", 'url' => "add.php?date=$year-$month-${day5}&time=17:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		)     ,    array(
			'id' => 333,
			'title' => "8 $r Available",
			'start' => "$year-$month-${day5}T18:00:00Z",
			'end' => "$year-$month-${day5}T19:00:00Z", 'url' => "add.php?date=$year-$month-${day5}&time=18:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "7 $r Available",
			'start' => "$year-$month-${day5}T19:00:00Z",
			'end' => "$year-$month-${day5}T20:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) ,    array(
			'id' => 333,
			'title' => "3 $r Available",
			'start' => "$year-$month-${day5}T20:00:00Z",
			'end' => "$year-$month-${day5}T21:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#006633'
		) 
	                 ,

		
		array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T08:00:00Z",
			'end' => "$year-$month-${day6}T09:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day6}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),

		array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T09:00:00Z",
			'end' => "$year-$month-${day6}T10:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day6}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),

    	array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T10:00:00Z",
			'end' => "$year-$month-${day6}T11:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day6}&time=10:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),
    
        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T11:00:00Z",
			'end' => "$year-$month-${day6}T12:00:00Z",
            'allDay' => false,
           
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,
    
      array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T12:00:00Z",
			'end' => "$year-$month-${day6}T13:00:00Z",
            'allDay' => false, 
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,


        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T13:00:00Z",
			'end' => "$year-$month-${day6}T14:00:00Z",
            'allDay' => false,     'url' => "add.php?date=$year-$month-${day6}&time=13:00",
            'resourceId' => 3 ,
            'color'=>'#800000'
		)        ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T14:00:00Z",
			'end' => "$year-$month-${day6}T15:00:00Z",'url' => "add.php?date=$year-$month-${day6}&time=14:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T15:00:00Z",
			'end' => "$year-$month-${day6}T16:00:00Z",  'url' => "add.php?date=$year-$month-${day6}&time=15:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) 
    
    
    ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T16:00:00Z",
			'end' => "$year-$month-${day6}T17:00:00Z",   'url' => "add.php?date=$year-$month-${day6}&time=16:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T17:00:00Z",
			'end' => "$year-$month-${day6}T18:00:00Z", 'url' => "add.php?date=$year-$month-${day6}&time=17:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		)     ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T18:00:00Z",
			'end' => "$year-$month-${day6}T19:00:00Z", 'url' => "add.php?date=$year-$month-${day6}&time=18:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T19:00:00Z",
			'end' => "$year-$month-${day6}T20:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day6}T20:00:00Z",
			'end' => "$year-$month-${day6}T21:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		)   ,
		
		array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T08:00:00Z",
			'end' => "$year-$month-${day7}T09:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day7}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),

		array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T09:00:00Z",
			'end' => "$year-$month-${day7}T10:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day7}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),

    	array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T10:00:00Z",
			'end' => "$year-$month-${day7}T11:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day7}&time=10:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),
    
        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T11:00:00Z",
			'end' => "$year-$month-${day7}T12:00:00Z",
            'allDay' => false,
           
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,
    
      array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T12:00:00Z",
			'end' => "$year-$month-${day7}T13:00:00Z",
            'allDay' => false, 
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,


        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T13:00:00Z",
			'end' => "$year-$month-${day7}T14:00:00Z",
            'allDay' => false,     'url' => "add.php?date=$year-$month-${day7}&time=13:00",
            'resourceId' => 3 ,
            'color'=>'#800000'
		)        ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T14:00:00Z",
			'end' => "$year-$month-${day7}T15:00:00Z",'url' => "add.php?date=$year-$month-${day7}&time=14:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T15:00:00Z",
			'end' => "$year-$month-${day7}T16:00:00Z",  'url' => "add.php?date=$year-$month-${day7}&time=15:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) 
    
    
    ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T16:00:00Z",
			'end' => "$year-$month-${day7}T17:00:00Z",   'url' => "add.php?date=$year-$month-${day7}&time=16:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T17:00:00Z",
			'end' => "$year-$month-${day7}T18:00:00Z", 'url' => "add.php?date=$year-$month-${day7}&time=17:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		)     ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T18:00:00Z",
			'end' => "$year-$month-${day7}T19:00:00Z", 'url' => "add.php?date=$year-$month-${day7}&time=18:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T19:00:00Z",
			'end' => "$year-$month-${day7}T20:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day7}T20:00:00Z",
			'end' => "$year-$month-${day7}T21:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,

		
		array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T08:00:00Z",
			'end' => "$year-$month-${day8}T09:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day8}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),

		array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T09:00:00Z",
			'end' => "$year-$month-${day8}T10:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day8}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),

    	array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T10:00:00Z",
			'end' => "$year-$month-${day8}T11:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day8}&time=10:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),
    
        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T11:00:00Z",
			'end' => "$year-$month-${day8}T12:00:00Z",
            'allDay' => false,
           
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,
    
      array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T12:00:00Z",
			'end' => "$year-$month-${day8}T13:00:00Z",
            'allDay' => false, 
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,


        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T13:00:00Z",
			'end' => "$year-$month-${day8}T14:00:00Z",
            'allDay' => false,     'url' => "add.php?date=$year-$month-${day8}&time=13:00",
            'resourceId' => 3 ,
            'color'=>'#800000'
		)        ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T14:00:00Z",
			'end' => "$year-$month-${day8}T15:00:00Z",'url' => "add.php?date=$year-$month-${day8}&time=14:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T15:00:00Z",
			'end' => "$year-$month-${day8}T16:00:00Z",  'url' => "add.php?date=$year-$month-${day8}&time=15:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) 
    
    
    ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T16:00:00Z",
			'end' => "$year-$month-${day8}T17:00:00Z",   'url' => "add.php?date=$year-$month-${day8}&time=16:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T17:00:00Z",
			'end' => "$year-$month-${day8}T18:00:00Z", 'url' => "add.php?date=$year-$month-${day8}&time=17:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		)     ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T18:00:00Z",
			'end' => "$year-$month-${day8}T19:00:00Z", 'url' => "add.php?date=$year-$month-${day8}&time=18:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T19:00:00Z",
			'end' => "$year-$month-${day8}T20:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day8}T20:00:00Z",
			'end' => "$year-$month-${day8}T21:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,

		
		array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T08:00:00Z",
			'end' => "$year-$month-${day9}T09:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day9}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),

		array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T09:00:00Z",
			'end' => "$year-$month-${day9}T10:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day9}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),

    	array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T10:00:00Z",
			'end' => "$year-$month-${day9}T11:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day9}&time=10:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),
    
        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T11:00:00Z",
			'end' => "$year-$month-${day9}T12:00:00Z",
            'allDay' => false,
           
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,
    
      array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T12:00:00Z",
			'end' => "$year-$month-${day9}T13:00:00Z",
            'allDay' => false, 
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,


        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T13:00:00Z",
			'end' => "$year-$month-${day9}T14:00:00Z",
            'allDay' => false,     'url' => "add.php?date=$year-$month-${day9}&time=13:00",
            'resourceId' => 3 ,
            'color'=>'#800000'
		)        ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T14:00:00Z",
			'end' => "$year-$month-${day9}T15:00:00Z",'url' => "add.php?date=$year-$month-${day9}&time=14:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T15:00:00Z",
			'end' => "$year-$month-${day9}T16:00:00Z",  'url' => "add.php?date=$year-$month-${day9}&time=15:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) 
    
    
    ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T16:00:00Z",
			'end' => "$year-$month-${day9}T17:00:00Z",   'url' => "add.php?date=$year-$month-${day9}&time=16:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T17:00:00Z",
			'end' => "$year-$month-${day9}T18:00:00Z", 'url' => "add.php?date=$year-$month-${day9}&time=17:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		)     ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T18:00:00Z",
			'end' => "$year-$month-${day9}T19:00:00Z", 'url' => "add.php?date=$year-$month-${day9}&time=18:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T19:00:00Z",
			'end' => "$year-$month-${day9}T20:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day9}T20:00:00Z",
			'end' => "$year-$month-${day9}T21:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,

		
		array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T08:00:00Z",
			'end' => "$year-$month-${day10}T09:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day10}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),

		array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T09:00:00Z",
			'end' => "$year-$month-${day10}T10:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day10}&time=09:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),

    	array(
			'id' => 222,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T10:00:00Z",
			'end' => "$year-$month-${day10}T11:00:00Z",
            'allDay' => false,
			'url' => "add.php?date=$year-$month-${day10}&time=10:00",
            'resourceId' => 2       ,
            'color'=>'#800000'
		),
    
        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T11:00:00Z",
			'end' => "$year-$month-${day10}T12:00:00Z",
            'allDay' => false,
           
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,
    
      array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T12:00:00Z",
			'end' => "$year-$month-${day10}T13:00:00Z",
            'allDay' => false, 
            'resourceId' => 3 ,
            'color'=>'#800000'
		)  ,


        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T13:00:00Z",
			'end' => "$year-$month-${day10}T14:00:00Z",
            'allDay' => false,     'url' => "add.php?date=$year-$month-${day10}&time=13:00",
            'resourceId' => 3 ,
            'color'=>'#800000'
		)        ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T14:00:00Z",
			'end' => "$year-$month-${day10}T15:00:00Z",'url' => "add.php?date=$year-$month-${day10}&time=14:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T15:00:00Z",
			'end' => "$year-$month-${day10}T16:00:00Z",  'url' => "add.php?date=$year-$month-${day10}&time=15:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) 
    
    
    ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T16:00:00Z",
			'end' => "$year-$month-${day10}T17:00:00Z",   'url' => "add.php?date=$year-$month-${day10}&time=16:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,

        array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T17:00:00Z",
			'end' => "$year-$month-${day10}T18:00:00Z", 'url' => "add.php?date=$year-$month-${day10}&time=17:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		)     ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T18:00:00Z",
			'end' => "$year-$month-${day10}T19:00:00Z", 'url' => "add.php?date=$year-$month-${day10}&time=18:00",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T19:00:00Z",
			'end' => "$year-$month-${day10}T20:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) ,    array(
			'id' => 333,
			'title' => "Fully Booked",
			'start' => "$year-$month-${day10}T20:00:00Z",
			'end' => "$year-$month-${day10}T21:00:00Z",
            'allDay' => false,
            'resourceId' => 3 ,
            'color'=>'#800000'
		) 
	
	
	
	));
  
  
  

?>
