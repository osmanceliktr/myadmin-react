import React, { Suspense, useEffect } from 'react'
import { HashRouter, Route, Routes } from 'react-router-dom'
import { useDispatch, useSelector } from 'react-redux'
import PrivateRoute from './components/PrivateRoute'
import { CSpinner, useColorModes } from '@coreui/react'
import { refreshLogin , logout } from './store/actions/authActions'

import './scss/style.scss'
import './scss/examples.scss'

// Containers
const DefaultLayout = React.lazy(() => import('./layout/DefaultLayout'))

// Pages
const Login = React.lazy(() => import('./views/pages/login/Login'))
const Page404 = React.lazy(() => import('./views/pages/page404/Page404'))
const Page500 = React.lazy(() => import('./views/pages/page500/Page500'))

const App = () => {
  const { isColorModeSet, setColorMode } = useColorModes('coreui-free-react-admin-template-theme')
  const storedTheme = useSelector((state) => state.theme)

  const dispatch = useDispatch()

  useEffect(() => {
    // localStorage'daki accessToken'ı kontrol et
  const accessToken = localStorage.getItem('accessToken');
  const refreshToken = localStorage.getItem('refreshToken');
    
    // Eğer accessToken varsa, kullanıcı giriş yapmış demektir
    if (accessToken) {
      dispatch(refreshLogin()); // Redux state'ini güncelle
    } else {
      // Token'lar yoksa logout işlemi yapılır
      dispatch(logout());
    }
  }, [dispatch]);

  // useEffect(() => {
  //   // Token'ların olup olmadığını kontrol et
  //   const accessToken = localStorage.getItem('accessToken');
  //   const refreshToken = localStorage.getItem('refreshToken');
  
  //   // Eğer accessToken ve refreshToken yoksa, logout işlemini yap
  //   if (!accessToken || !refreshToken) {
  //     dispatch(logout()); // Kullanıcıyı çıkış yaptır
  //   }
  // }, []);

  useEffect(() => {
    const urlParams = new URLSearchParams(window.location.href.split('?')[1])
    const theme = urlParams.get('theme') && urlParams.get('theme').match(/^[A-Za-z0-9\s]+/)[0]
    if (theme) {
      setColorMode(theme)
    }

    if (isColorModeSet()) {
      return
    }

    setColorMode(storedTheme)
  }, []) 

  return (
    <HashRouter>
      <Suspense
        fallback={
          <div className="pt-3 text-center">
            <CSpinner color="primary" variant="grow" />
          </div>
        }
      >
        <Routes>
          <Route exact path="/login" name="Login Page" element={<Login />} />
          <Route exact path="/404" name="Page 404" element={<Page404 />} />
          <Route exact path="/500" name="Page 500" element={<Page500 />} />
          <Route path="*" name="Home" element={
            <PrivateRoute>
                <DefaultLayout/>
              </PrivateRoute>
            } />
        </Routes>
      </Suspense>
    </HashRouter>
  )
}

export default App
