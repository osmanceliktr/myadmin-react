import React from 'react'

const IndexPages = React.lazy(() => import('./views/pages/home/IndexPages'))

const routes =[
    { path:'/', exact: true, name: 'Default'},
    { path: '/home/index', name: 'IndexPages', element: IndexPages },
]

export default routes