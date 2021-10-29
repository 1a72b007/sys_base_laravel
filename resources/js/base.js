
var base = {

    //輸入,物件or陣列params
    params_to_list(input = [], need_params = []) {
        return input.map(
            element => {
                let base_obj = {}
                need_params.forEach(
                    item => {
                        base_obj[item] = element[item]
                    }
                )
                return base_obj
            }
        )
    },

    //輸入,物件or陣列params
    params_to_obj(input, need_params = []) {
        let base_obj = {}
        need_params.forEach(
            item => {
                base_obj[item] = input[item]
            }
        )
        return base_obj
    },

    //輸入
    refresh_list_index(input) {
        input.forEach(
            (item, index) => {
                if (!item.hasOwnProperty('index')) {
                    item.index = ""
                }
                item.index = index + 1
            }
        )
        return input
    },

    //輸入
    sum_reduce(input) {
        if (input.length == 0) return 0
        const reducer = (total, value) => parseInt(total) + parseInt(value);
        const price = input.reduce(reducer);
        return parseInt(price)
    },

    //輸入
    subtract_reduce(input) {
        if (input.length == 0) return 0
        const reducer = (total, value) => parseInt(total) - parseInt(value);
        const price = input.reduce(reducer);
        return parseInt(price)
    },

    //輸入
    get_text(input) {
        switch (input) {
            case 'set_up':
                return `未結帳`;
            case 'locking':
                return `確認並鎖定`;
            case 'paymented':
                return `已結帳`;
            case 'cancelled':
                return `已退單`;
            case 'member_star':
                return `客戶星號`;
            case 'product_star':
                return `產品星號`;
            case 'basic':
                return `基本訂閱`;
            case 'advanced':
                return `進階功能`;
            case 'not_activated':
                return `未啟用`;
            case 'activated':
                return `已啟用`;
            case 'disabled':
                return `已停用`;
            case 'unpaid':
                return `未付款`;
            case 'paid':
                return `已付款`;
            case 'confirmed':
                return `待確認`;
            case 'waiting':
                return `等確認`;
            case 'checked':
                return `已確認，等待預約的客人到來`;
            case 'check_in':
                return `預約的客人到了`;
            case 'cancel':
                return `預約的客人取消了`;
            case 'break':
                return `預約的客人被判斷爽約`;
        }
    },

    //輸入
    cancel_modal(input) {
        $(`#${input}`).modal('hide')
        return false;
    },

    //https://www.delftstack.com/howto/javascript/javascript-filter-object/
    //輸入
    object_filter(mainObject, filterFunction) {
        return Object.keys(mainObject)
            .filter(function (ObjectKey) {
                return filterFunction(mainObject[ObjectKey])
            })
            .reduce(function (result, ObjectKey) {
                result[ObjectKey] = mainObject[ObjectKey];
                return result;
            }, {});
    },

    //輸入
    array_group_by(input, prop) {
        return input.reduce(function (groups, item) {
            const val = item[prop]
            groups[val] = groups[val] || []
            groups[val].push(item)
            return groups
        }, {})
    },

    //輸入,符號,幾位
    format_number(input, symbol, index) {
        const arr = (input + '').split('.');
        const int = arr[0] + '';
        const fraction = arr[1] || '';
        const f = int.length % index;
        let r = int.substring(0, f);

        for (var i = 0; i < Math.floor(int.length / index); i++) {
            r += symbol + int.substring(f + i * index, f + (i + 1) * index)
        }

        if (f === 0) {
            r = r.substring(1);
        }
        return r + (!!fraction ? "." + fraction : '');
    }
}
export { base };
