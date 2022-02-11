/**
 * Created by koceila on 3/27/20.
 */
import VueRouter from 'vue-router'
// Pages
import Home from './components/pages/home/Home.vue'

import Login from './components/pages/login/Login.vue'


import ProductIndex from './components/pages/product/ProductIndex.vue'
import Product from './components/pages/product/Product.vue'
import BrandCategoryManagment from './components/pages/product/BrandCategoryManagment.vue'
import SuppliersData from './components/pages/survey/SuppliersData.vue'
import SupplierSurveyIndex from './components/pages/survey/SupplierSurveyIndex.vue'
import SalepointSurveyIndex from './components/pages/survey/SalepointSurveyIndex.vue'
import UserIndex from './components/pages/user/UserIndex.vue'
import SupplierIndex from './components/pages/supplier/SupplierIndex.vue'
import SalepointIndex from './components/pages/salepoint/SalepointIndex'
import StockIndex from './components/pages/stock/StockIndex'

import Dashboard from '././components/pages/dashboard/Dashboard.vue'

// Routes
const routes = [
    {
        path: "/",
        redirect: "/dashboard"
    },


    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },

    {
        path: '/home',
        name: 'home',
        component: Home,
        meta: {
            auth: true
        }
    },
    // USER ROUTES
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            auth: true
        }
    },
    {
        path: '/products',
        name: 'products',
        component: ProductIndex,
        meta: {
            auth: true
        }
    },

    {
        path: '/product/:id',
        name: 'products',
        component: Product,
        meta: {
            auth: true
        }
    },
    {
        path: '/users',
        name: 'users',
        component: UserIndex,
        meta: {
            auth: true
        }
    },

    {
        path: '/stock',
        name: 'stock',
        component: StockIndex,
        meta: {
            auth: true
        }
    },

    {
        path: '/salepointsurveys',
        name: 'salepointsurveys',
        component: SalepointSurveyIndex,
        meta: {
            auth: true
        }
    },
    {
        path: '/suppliersurveys',
        name: 'salepointsurveys',
        component: SuppliersData,
        meta: {
            auth: true
        }
    },
    {
        path: '/suppliers',
        name: 'suppliers',
        component: SupplierIndex,
        meta: {
            auth: true
        }
    },
    {
        path: '/salepoints',
        name: 'salepoints',
        component: SalepointIndex,
        meta: {
            auth: true
        }
    },
    {
        path: '/category',
        name: 'category',
        component: BrandCategoryManagment,
        meta: {
            auth: true
        }
    }
]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router
