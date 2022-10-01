import Confirm from './ViewImageDialog.vue';
import vuetify from '@plugins/vuetify';

const Install = {
	install(Vue, options) {
		const property = (options && options.property) || '$viewImages';
		var cmp;
		function createDialogCmp(options) {
			// create element as parent container of element
			const div = document.createElement('div');
			document.body.appendChild(div);

			return new Promise((resolve) => {
				cmp = new Vue(
					Object.assign(
						{
							vuetify //use vuetify to resolve theme dependency
						},
						Confirm,
						{
							propsData: Object.assign({}, Vue.prototype.$viewImages.options, options),
							destroyed: (c) => {
								resolve(cmp.value);
							}
						}
					)
				);
				// mount component to container
				cmp.$mount(div);
			});
		}

		function show(items, options = {}) {
			// console.log(options);

			options.images = items;
			return createDialogCmp(options);
		}

		Vue.prototype[property] = show;
		Vue.prototype[property].options = options || {};
	}
};

export default Install;
