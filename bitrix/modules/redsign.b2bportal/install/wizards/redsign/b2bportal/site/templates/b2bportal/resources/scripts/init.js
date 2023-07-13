import MenuAside from './app/menu.aside'
import { isPositionStickySupported } from './utils';

function init()
{
	new MenuAside();
	
	if (!isPositionStickySupported())
	{
		if (window.Sticky)
			new Sticky('.kt-portlet__head--is-sticky', {
				wrap: true
			});
	}
}

// page on ready
function onReady()
{
	init()
}

// composite data recieved
function onFrameDataReceived(json = {})
{
	if (!(json.dynamicBlocks || []).length)
	{
		return
	}

    init()
}

$(window).ready(onReady)
if (window.frameCacheVars !== undefined)
{
	BX.addCustomEvent("onFrameDataReceived", (json) => onFrameDataReceived(json))
}
