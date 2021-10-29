
import moment from 'moment';

const custom_validator = {

    after_date_validator: {
        getMessage(field, params, data) {
            return `${field} 不可比 ${window[params[0]].$refs.add_edit_modal.$refs[params[1]][0].label} 早`
        },
        validate(value, { vue_variable, ref_key ,date_format="YYYY-MM-DD" } = {}) {
            if (window[vue_variable].$refs.add_edit_modal) {
                let start_date = moment(window[vue_variable].$refs.add_edit_modal.$refs[ref_key][0].value,date_format).unix()
                let end_date = moment(value,date_format).unix()
                if (start_date > end_date) {
                    return false;
                }
                return true
            }
            return true
        }
    },

    isbigger_validator: {
        getMessage(field, params, data) {
            return `${field} 不可比 ${window[params[0]].$refs.add_edit_modal.$refs[params[1]][0].label} 大`
        },
        validate(value, { vue_variable, ref_key } = {}) {
            if (window[vue_variable].$refs.add_edit_modal) {
                let max_value = window[vue_variable].$refs.add_edit_modal.$refs[ref_key][0].value
                if (parseInt(value) > parseInt(max_value)) {
                    return false;
                }
                return true
            }
            return true
        }
    },
}

export default custom_validator