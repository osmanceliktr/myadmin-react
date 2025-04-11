import axios from 'axios'

export const login = (credentials) => async (dispatch,getState) => {
  try {

    const response = await axios.post('http://localhost:5000/api/loginUser', credentials)
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

    const response = await axios.post('http://localhost:5000/api/refresh', { refreshToken });
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
export const logout = () => async (dispatch) => {
  try {
    const refreshToken = localStorage.getItem('refreshToken');
    if (refreshToken) {
      // Backend'e çıkış isteği gönder
      await axios.post('http://localhost:5000/api/logout', { refreshToken });
    }
  } catch (error) {
    console.error('Logout error:', error);
  } finally {
    // Her durumda token'ları temizle
    localStorage.removeItem('accessToken');
    localStorage.removeItem('refreshToken');
    
    dispatch({ type: 'LOGOUT' });
  }
};