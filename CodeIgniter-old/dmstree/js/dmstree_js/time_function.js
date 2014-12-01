$(function () {
    
                $('#datetimepicker').datetimepicker({
                    pickTime: true
                });
            });
            
            
            /*
 * Name: Usage Meter
 * Date: 27/7/2014
 * Create by :Mahendra Kadam
 * Summary : To show useage meter 
 */
      var g1;
      
      window.onload = function(){
      var g1 = new JustGage({
          id: "g1", 
          value: getRandomInt(0, 100), 
          min: 0,
          max: 100,
          title: "Usage Meter",
          label: "",
          levelColorsGradient: false
        });
        setInterval(function() {
          g1.refresh(getRandomInt(0, 100));
        }, 5000);
      };
