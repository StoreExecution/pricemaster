/**
 * Created by koceila on 3/25/20.
 */
import axios from '@/config/axios.js'

export default {

    register(data) {
        return axios.post('register', data)
    },

    emailLink(data) {
        return axios.post('password/email', data)
    },

    resetPassword(data) {
        return axios.post('password/reset', data)
    },

}