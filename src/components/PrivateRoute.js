import React, { useEffect } from 'react'
import { Navigate } from 'react-router-dom'
import { useSelector, useDispatch } from 'react-redux'
import axios from 'axios'
import { logout } from '../store/actions/authActions'

const PrivateRoute = ({ children }) => {
  const dispatch = useDispatch()
  const accessToken = useSelector((state) => state.auth.accessToken)

  useEffect(() => {
    const checkTokenValidity = async () => {
      try {
        // Access token kontrolü
        await axios.post('/api/loginUser', {
          headers: { Authorization: `Bearer ${accessToken}` },
        })
      } catch (error) {
        if (error.response.status === 401) {
          // Token süresi dolmuş, refresh dene
          try {
            const refreshToken = localStorage.getItem('refreshToken')
            const response = await axios.post('/api/refresh', { refreshToken })

            const { accessToken: newAccessToken } = response.data
            localStorage.setItem('accessToken', newAccessToken)
            dispatch({ type: 'LOGIN_SUCCESS', payload: { accessToken: newAccessToken } })
          } catch (refreshError) {
            // Refresh token da geçersizse çıkış yap
            dispatch(logout())
          }
        }
      }
    }

    if (accessToken) {
      checkTokenValidity()
    }
  }, [accessToken, dispatch])

  return accessToken ? children : <Navigate to="/login" />
}

export default PrivateRoute
