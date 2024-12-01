import React from 'react'
import CIcon from '@coreui/icons-react'
import {
  cibReadme,
  cilFlower,
  cilLanguage,
} from '@coreui/icons'
import { CNavGroup, CNavItem } from '@coreui/react'

const _nav = [
  {
    component: CNavGroup,
    name: 'Kuran',
    icon: <CIcon icon={cibReadme} customClassName="nav-icon" />,
    items: [
      {
        component: CNavItem,
        name: 'Kuran Okuma',
        to: '/kuran/okuma',
      },
      {
        component: CNavItem,
        name: 'Sureler',
        to: '/kuran/sureler',
      },
      {
        component: CNavItem,
        name: 'Ezberlerim',
        to: '/kuran/erzberlerim',
      },
      {
        component: CNavItem,
        name: 'Arama',
        to: '/kuran/arama',
      },
      {
        component: CNavItem,
        name: 'Fihrist',
        to: '/kuran/fihrist',
      },
    ],
  },
  {
    component: CNavGroup,
    name: 'Hadisler',
    icon: <CIcon icon={cilFlower} customClassName="nav-icon" />,
    items: [
      {
        component: CNavItem,
        name: 'Hadis Okuma',
        to: '/hadis/okuma',
      },
      {
        component: CNavItem,
        name: 'Kitaplar',
        to: '/hadis/kitaplar',
      },
      {
        component: CNavItem,
        name: 'Favoriler',
        to: '/hadis/favoriler',
      },
    ],
  },
  {
    component: CNavGroup,
    name: 'Arapça',
    icon: <CIcon icon={cilLanguage} customClassName="nav-icon" />,
    items: [
      {
        component: CNavItem,
        name: 'Kelime Ara',
        to: '/arapca/ara',
      },
      {
        component: CNavItem,
        name: 'Çekimler',
        to: '/arapca/cekimler',
      },
      {
        component: CNavItem,
        name: 'Kuran Sözlüğü',
        to: '/arapca/sozluk',
      },
    ],
  },
]

export default _nav
