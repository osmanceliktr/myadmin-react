import React from 'react'

const KuranPages = React.lazy(() => import('./views/kuran/KuranPages'))

const routes =[
    { path:'/', exact: true, name: 'Default'},
    { path: '/kuran/okuma', name: 'Kuran', element: KuranPages },
]

export default routes