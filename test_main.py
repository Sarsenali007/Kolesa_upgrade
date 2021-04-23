import math
import time

from selenium import webdriver
from selenium.common.exceptions import NoAlertPresentException  # в начале файла

# link = "http://selenium1py.pythonanywhere.com/"

link = "http://selenium1py.pythonanywhere.com/catalogue/the-shellcoders-handbook_209/?promo=newYear"
browser = webdriver.Chrome('C:\chromedriver.exe')
browser.get(link)
button = browser.find_element_by_css_selector("#add_to_basket_form > button")
button.click()


def solve_quiz_and_get_code(self):
    alert = self.browser.switch_to.alert
    x = alert.text.split(" ")[2]
    answer = str(math.log(abs((12 * math.sin(float(x))))))
    alert.send_keys(answer)
    alert.accept()
    try:
        alert = self.browser.switch_to.alert
        alert_text = alert.text
        print(f"Your code: {alert_text}")
        alert.accept()
    except NoAlertPresentException:
        print("No second alert presented")

    # ожидание чтобы визуально оценить результаты прохождения скрипта


time.sleep(5)
# закрываем браузер после всех манипуляций
browser.quit()

"""
#########################################################################################################

try:
    link = "http://suninjuly.github.io/registration1.html"
    browser = webdriver.Chrome('C:\chromedriver.exe')
    browser.get(link)

    # Ваш код, который заполняет обязательные поля

    input1 = browser.find_element_by_class_name('form-control.first')
    input1.send_keys("Ivan")
    input2 = browser.find_element_by_class_name('form-control.second')
    input2.send_keys("Petrov")
    input3 = browser.find_element_by_xpath('/html/body/div/form/div[1]/div[3]/input')
    input3.send_keys("123@mail.com")

    # Отправляем заполненную форму
    button = browser.find_element_by_css_selector("button.btn")
    button.click()

    # Проверяем, что смогли зарегистрироваться
    # ждем загрузки страницы
    time.sleep(1)

    # находим элемент, содержащий текст
    welcome_text_elt = browser.find_element_by_tag_name("h1")
    # записываем в переменную welcome_text текст из элемента welcome_text_elt
    welcome_text = welcome_text_elt.text

    # с помощью assert проверяем, что ожидаемый текст совпадает с текстом на странице сайта
    assert "Congratulations! You have successfully registered!" == welcome_text

finally:
    # ожидание чтобы визуально оценить результаты прохождения скрипта
    time.sleep(10)
    # закрываем браузер после всех манипуляций
    browser.quit()

#########################################################################################################

def calc():
    return str(math.log(int(time.time())))

#"236895/step/1", "236896/step/1", "236897/step/1", "236898/step/1", "236899/step/1", "236903/step/1", "236904/step/1",
#@pytest.mark.xfail
@pytest.mark.parametrize('links', ["236895/step/1", "236896/step/1", "236897/step/1", "236898/step/1", "236899/step/1", "236903/step/1", "236904/step/1", "236905/step/1"])
class TestLogin:
    def test_123(self, links):
        link = f"https://stepik.org/lesson/{links}/"
        browser = webdriver.Chrome('C:\chromedriver.exe')
        browser.get(link)
        browser.implicitly_wait(10)
        element = browser.find_element_by_tag_name('textarea')
        element.send_keys(calc())
        button = browser.find_element_by_css_selector("#ember72 > div > section > div > div.attempt__inner > div.attempt__actions > button")
    #   WebDriverWait(browser, 3).until(EC.element_to_be_clickable((By.ID, '#ember72 > div > section > div > div.attempt__inner > div.attempt__actions > button')))
        button.click()
        print("HIIIII")
    #   browser.find_element_by_css_selector("# ember72 > div > section > div > div.attempt__inner > div.attempt__actions > button").click()
        element1 = WebDriverWait(browser,15).until(EC.visibility_of_element_located((By.CSS_SELECTOR,".smart-hints__hint")))
        if ("Correct"!=element1.text):
            print(element1.text)




######################################################
class TestMainPage():
    # номер 1
    @pytest.mark.xfail
    def test_guest_can_login(self, browser):
        assert True
        print("@")

    # номер 2
    @pytest.mark.regression
    def test_guest_can_add_book_from_catalog_to_basket(self, browser):
        assert True
        print("@")

class TestBasket():
    # номер 3
    @pytest.mark.skip(reason="not implemented yet")
    @pytest.mark.smoke
    def test_guest_can_go_to_payment_page(self, browser):
        assert True
        print("@")
    # номер 4
    @pytest.mark.smoke
    def test_guest_can_see_total_price(self, browser):
        assert True
        print("@")

@pytest.mark.skip
class TestBookPage():
    # номер 5
    @pytest.mark.smoke
    def test_guest_can_add_book_to_basket(self, browser):
        assert True
        print("@")
    # номер 6
    @pytest.mark.regression
    def test_guest_can_see_book_price(self, browser):
        assert True
        print("@")

# номер 7
@pytest.mark.beta_users
@pytest.mark.smoke
def test_guest_can_open_gadget_catalogue(browser):
    assert True
    print("@")

#######################################################
@pytest.mark.xfail(strict=True)
def test_succeed():
    assert True

@pytest.mark.xfail
def test_not_succeed():
    assert False

@pytest.mark.skip
def test_skipped():
    assert False

#####################################
@pytest.fixture(scope="function")
def browser():
    print("\nstart browser for test..")
    browser = webdriver.Chrome('C:\chromedriver.exe')
    yield browser
    print("\nquit browser..")
    browser.quit()

@pytest.mark.xfail(reason="fixing this bug right now")
def test_guest_should_see_search_button_on_the_main_page(self, browser):
    browser.get(link)
    browser.find_element_by_css_selector("button.favorite")
    
class TestMainPage1():

    def test_guest_should_see_login_link(self, browser):
        browser.get(link)
        browser.find_element_by_css_selector("#login_link")

    def test_guest_should_see_basket_link_on_the_main_page(self, browser):
        browser.get(link)
        browser.find_element_by_css_selector(".basket-mini .btn-group > a")

    @pytest.mark.xfail
    def test_guest_should_see_search_button_on_the_main_page(self, browser):
        browser.get(link)
        browser.find_element_by_css_selector("button.favorite")

##########################################################################################
calcdef (x):
    return str(math.log(abs(12 * math.sin(int(x)))))

link = "http://selenium1py.pythonanywhere.com/"


@pytest.fixture(scope="function")
def browser():
    print("\nstart browser for test..")
    browser = webdriver.Chrome()
    yield browser
    print("\nquit browser..")
    browser.quit()


class TestMainPage1():

    @pytest.mark.smoke
    def test_guest_should_see_login_link(self, browser):
        browser.get(link)
        browser.find_element_by_css_selector("#login_link")

    @pytest.mark.regression
    def test_guest_should_see_basket_link_on_the_main_page(self, browser):
        browser.get(link)
        browser.find_element_by_css_selector(".basket-mini .btn-group > a")



class TestAbs(unittest.TestCase):
    def test_abs1(self):
        link = "http://suninjuly.github.io/registration1.html"
        browser = webdriver.Chrome('C:\chromedriver.exe')
        browser.get(link)

        option2 = browser.find_element_by_css_selector("body > div > form > div.first_block > div.form-group.first_class > input")
        option2.send_keys("qwerty")

        option1 = browser.find_element_by_css_selector("body > div > form > div.first_block > div.form-group.third_class > input")
        option1.send_keys("qwerty@qwr.ty")

        option = browser.find_element_by_css_selector("body > div > form > div.first_block > div.form-group.second_class > input")
        option.send_keys("Testov")

        button = browser.find_element_by_css_selector("body > div > form > button")
        button.click()

        self.assertEqual()

class TestAbs(unittest.TestCase):
    def test_abs2(self):
        link = "http://suninjuly.github.io/registration2.html"
        browser = webdriver.Chrome('C:\chromedriver.exe')
        browser.get(link)

        option2 = browser.find_element_by_css_selector("body > div > form > div.first_block > div.form-group.first_class > input")
        option2.send_keys("qwerty")

        option1 = browser.find_element_by_css_selector("body > div > form > div.first_block > div.form-group.third_class > input")
        option1.send_keys("qwerty@qwr.ty")

        option = browser.find_element_by_css_selector("body > div > form > div.first_block > div.form-group.second_class > input")
        option.send_keys("Testov")

        button = browser.find_element_by_css_selector("body > div > form > button")
        button.click()

        self.assertEqual()

if __name__ == "__main__":
    unittest.main()

####################################################################
finally:
# успеваем скопировать код за 3 секунд
time.sleep(3)
# закрываем браузер после всех манипуляций
browser.quit()
#

    button = browser.find_element_by_xpath("//*[@id='book']")
    button = WebDriverWait(browser, 13).until(
        EC.text_to_be_present_in_element((By.ID, "price"), "$100"))
    button = browser.find_element_by_xpath("//*[@id='book']")
    button.click()

    x1 = browser.find_element_by_xpath('//*[@id="input_value"]')
    x = x1.text
    y = calc(int(x))

    element = browser.find_element_by_id('answer')
    element.send_keys(y)

    button = browser.find_element_by_css_selector("body > form > div > div > button")
    button.click()
#

    button = browser.find_element_by_css_selector("body > form > div > div > button")
    button.click()

    new_window = browser.window_handles[1]
    browser.switch_to.window(new_window)

    x1 = browser.find_element_by_xpath('//*[@id="input_value"]')
    x = x1.text
    y = calc(int(x))

    element = browser.find_element_by_id('answer')
    element.send_keys(y)

    button = browser.find_element_by_css_selector("body > form > div > div > button")
    button.click()
#
    button = browser.find_element_by_css_selector("body > form > div > div > button")
    button.click()

    confirm = browser.switch_to.alert
    confirm.accept()

    x1 = browser.find_element_by_xpath('//*[@id="input_value"]')
    x = x1.text
    y = calc(int(x))

    element = browser.find_element_by_id('answer')
    element.send_keys(y)

    button = browser.find_element_by_css_selector("body > form > div > div > button")
    button.click()
    
#Заполенение формы
    option2 = browser.find_element_by_css_selector("body > div > form > div > input:nth-child(2)")
    option2.send_keys("qwerty")

    option1 = browser.find_element_by_css_selector("body > div > form > div > input:nth-child(4)")
    option1.send_keys("qwerty")

    option = browser.find_element_by_css_selector("body > div > form > div > input:nth-child(6)")
    option.send_keys("twst@tt.sy")

    current_dir = os.path.abspath(os.path.dirname(__file__))
    file_name = "123.txt"
    file_path = os.path.join(current_dir, file_name)
    element = browser.find_element_by_css_selector("#file")
    element.send_keys(file_path)

    button = browser.find_element_by_css_selector("body > div > form > button")
    button.click()

#1
    button = browser.find_element_by_tag_name("button")
    browser.execute_script("return arguments[0].scrollIntoView(true);", button)
    button.click()

    x1 = browser.find_element_by_xpath('//*[@id="input_value"]')
    x = x1.text
    y = calc(int(x))
    element = browser.find_element_by_id('answer')
    element.send_keys(y)

    option1 = browser.find_element_by_id("robotCheckbox")
    option1.click()

    option1 = browser.find_element_by_css_selector("[for='robotsRule']")
    option1.click()

    button = browser.find_element_by_css_selector("body > div > form > button")
    button.click()
 
    x2 = browser.find_element_by_xpath('//*[@id="num2"]')
    x3 = x2.text
    y2 = int(x3)

    y = int(y1+y2)
    print(y)
    browser.find_element_by_tag_name("select").click()
    #browser.find_element_by_css_selector("[value='y']").click()
    select = Select(browser.find_element_by_tag_name("select"))
    select.select_by_value(str(y))
    # element = browser.find_element_by_id('answer')
    #element.send_keys(y)

    # option1 = browser.find_element_by_id("robotCheckbox")
    # option1.click()

    # option1 = browser.find_element_by_css_selector("[for='robotsRule']")
    # option1.click()

    button = browser.find_element_by_css_selector("body > div > form > button")
    button.click()
    """

# не забываем оставить пустую строку в конце файла
