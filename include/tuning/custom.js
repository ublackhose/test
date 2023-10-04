$(document).ready(function() {

    document.addEventListener('rs.tuning.onBeforeGetReadyMacros', function(e) {

        var macrosList = e.detail.macrosList;
            color11 = macrosList['COLOR_1_1'],
            rsColor11 = new RS.Color(color11),
            color11yiq =  ((rsColor11._rgb.R * 299) + (rsColor11._rgb.G * 587) + (rsColor11._rgb.B * 114)) / 1000,
			color12 = macrosList['COLOR_1_2'],
            rsColor12 = new RS.Color(color12),
			color12yiq =  ((rsColor12._rgb.R * 299) + (rsColor12._rgb.G * 587) + (rsColor12._rgb.B * 114)) / 1000;
        
        rsTuning.setMacros('COLOR_1_1_YIQ', color11yiq > 150 ? '202020' : 'FFFFFF');    
        rsTuning.setMacros('COLOR_1_1_YIQ_HUE_1', color11yiq => 150 ? rsColor11.darken(10).getHex() :  rsColor11.lighten(10).getHex() );
        rsTuning.setMacros('COLOR_1_1_YIQ_HUE_2', color11yiq > 150 ? rsColor11.darken(15).getHex() : rsColor11.lighten(15).getHex());
        rsTuning.setMacros('COLOR_1_1_DARKEN_5_PERSENT', rsColor11.darken(5).getHex());
        rsTuning.setMacros('COLOR_1_1_DARKEN_10_PERSENT', rsColor11.darken(10).getHex());
		rsTuning.setMacros('COLOR_1_1_BRAND', rsColor11.darken(2.1568627450980316).getHex());
		rsTuning.setMacros('COLOR_1_2_YIQ', color12yiq > 150 ? '000000' : 'f2f5ff');
		rsTuning.setMacros('COLOR_1_2_DARKEN', rsColor12.darken(5.5).getHex());


        //rsTuning.setMacros('COLOR_1_2_DARKEN_10_PERSENT', rsColor12.darken(10).getHex());
    });

});
 