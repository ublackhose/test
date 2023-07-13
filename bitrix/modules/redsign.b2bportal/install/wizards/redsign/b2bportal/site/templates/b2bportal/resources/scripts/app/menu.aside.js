export default class MenuAside
{

	constructor()
	{
		this.cookieName = 'kt-aside-minimize'

		this.classActiveBody = 'kt-aside--minimize'
		this.classActiveBtn = 'kt-aside__brand-aside-toggler--active'

		this.$body = document.querySelector('body')
		this.$button = document.querySelector('.kt-aside__brand-aside-toggler')

		this.initAsideView()
		this.initEvents()
	}

	initAsideView()
	{
		if (BX.getCookie(this.cookieName) == 'Y')
		{
			this.$body.classList.add(this.classActiveBody)
			this.$button.classList.add(this.classActiveBtn)
		}
	}

	initEvents()
	{
		this.$button.addEventListener('click', (e) => {
			this.onClick()
		})
	}

	onClick()
	{
		if (this.$button.classList.contains(this.classActiveBtn))
		{
			BX.setCookie(this.cookieName, 'Y');
		}
		else
		{
			BX.setCookie(this.cookieName, 'N');
		}

		setTimeout(() => KTApp.initSticky(), 300)
	}

}
