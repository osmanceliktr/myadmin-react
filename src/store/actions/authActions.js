import axios from 'axios'

export const login = (credentials) => async (dispatch) => {
  try {
    const response = await axios.post('/api/loginUser', credentials)
    const { accessToken, refreshToken } = response.data

    // Token'ları localStorage'e kaydet
    localStorage.setItem('accessToken', accessToken)
    localStorage.setItem('refreshToken', refreshToken)


    dispatch({ type: 'LOGIN_SUCCESS', payload: { accessToken } })

  } catch (error) {
    console.error('Login failed:', error)
    dispatch({ type: 'LOGIN_FAILURE' })
  }
}

export const logout = () => {
  // Token'ları temizle
  localStorage.removeItem('accessToken')
  localStorage.removeItem('refreshToken')
  
  return { type: 'LOGOUT' }
}