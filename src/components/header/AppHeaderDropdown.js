import React from 'react'
import {
  CAvatar,
  CDropdown,
  CDropdownDivider,
  CDropdownHeader,
  CDropdownItem,
  CDropdownMenu,
  CDropdownToggle,
} from '@coreui/react'
import {
  cilSettings,
  cilAccountLogout,
  cilUser,
} from '@coreui/icons'
import CIcon from '@coreui/icons-react'

import osman from '../../assets/osman.png'
import { useDispatch } from 'react-redux'
import { logout } from '../../store/actions/authActions'
import { useNavigate } from 'react-router-dom'

const AppHeaderDropdown = () => {

  const dispatch = useDispatch()
  const navigate = useNavigate() 

  const handleLogout = () => {
    localStorage.setItem('isAuthenticated', 'false')
    dispatch(logout()) // localStorage ve Redux temizlenecek
    navigate('/login')
  }

  return (
    <CDropdown variant="nav-item">
      <CDropdownToggle placement="bottom-end" className="py-0 pe-0" caret={false}>
        <CAvatar src={osman} size="md" />
      </CDropdownToggle>
      <CDropdownMenu className="pt-0" placement="bottom-end">
        <CDropdownHeader className="bg-body-secondary fw-semibold my-2">Kullanıcı Bilgileri</CDropdownHeader>
        <CDropdownItem href="#">
          <CIcon icon={cilUser} className="me-2" />
          Profilim
        </CDropdownItem>
        <CDropdownItem href="#">
          <CIcon icon={cilSettings} className="me-2" />
          Ayarlar
        </CDropdownItem>
        
        <CDropdownDivider />
        <CDropdownItem onClick={handleLogout} href="#">
          <CIcon icon={cilAccountLogout} className="me-2" />
          Çıkış
        </CDropdownItem>
      </CDropdownMenu>
    </CDropdown>
  )
}

export default AppHeaderDropdown
