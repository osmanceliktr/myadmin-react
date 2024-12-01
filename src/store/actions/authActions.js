import axios from 'axios'

export const login = (credentials) => async (dispatch,getState) => {
  try {
    console.log(credentials)
    console.log(credentials)
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
export const refreshLogin = () => async (dispatch) => {
  try {
    const refreshToken = localStorage.getItem('refreshToken');
    if (!refreshToken) throw new Error('Refresh token bulunamadı');

    const response = await axios.post('/api/refresh', { refreshToken });
    const { accessToken } = response.data;

    // Yeni token'ları localStorage'a kaydet
    localStorage.setItem('accessToken', accessToken);

    // Redux state'ini güncelle
    dispatch({ type: 'LOGIN_SUCCESS', payload: { accessToken } });

  } catch (error) {
    console.error('Refresh token failed:', error);
    dispatch({ type: 'LOGIN_FAILURE' });
  }
};
export const logout = () => {
  // Token'ları temizle
  localStorage.removeItem('accessToken')
  localStorage.removeItem('refreshToken')
  
  return { type: 'LOGOUT' }
}