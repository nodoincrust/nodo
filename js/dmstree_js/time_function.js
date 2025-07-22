/*
 * Name: Usage Meter
 * Date: 27/7/2014
 * Create by :Mahendra Kadam
 * Summary : To show useage meter 
 */
      var g1;
     function showmeter(value,max){
      var g1 = new JustGage({
          id: "g1", 
          value: value,//50, //getRandomInt(0, 100), 
          min: 0,
          max: max,//100,
          title: "Usage Meter",
          label: "MB",
          levelColorsGradient: false
        });
        
      };
/*setInterval(function() {
          g1.refresh(getRandomInt(0, 100));
        }, 5000);*/