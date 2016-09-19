
--
-- Структура таблицы `{dbPrefix}articles`
--

DROP TABLE IF EXISTS `{dbPrefix}articles`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_ru` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `page_body_ru` text NOT NULL,
  `page_body_en` text NOT NULL,
  `short_page_body_ru` text NOT NULL,
  `short_page_body_en` text NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sorter` int(11) NOT NULL,
  `seo_title_ru` varchar(255) NOT NULL,
  `seo_title_en` varchar(255) NOT NULL,
  `seo_keywords_ru` text NOT NULL,
  `seo_keywords_en` text NOT NULL,
  `seo_description_ru` text NOT NULL,
  `seo_description_en` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`),
  FULLTEXT KEY `title` (`title_ru`),
  FULLTEXT KEY `page_body` (`page_body_ru`),
  FULLTEXT KEY `short_page_body` (`short_page_body_ru`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `{dbPrefix}articles`
--

INSERT INTO `{dbPrefix}articles` (`id`, `title_ru`, `title_en`, `page_body_ru`, `page_body_en`, `short_page_body_ru`, `short_page_body_en`, `date_updated`, `active`, `sorter`, `seo_title_ru`, `seo_title_en`, `seo_keywords_ru`, `seo_keywords_en`, `seo_description_ru`, `seo_description_en`) VALUES
(1, 'Настраиваем зеркала автомобиля', 'Tune car mirrors', '<p>Речь идёт о&nbsp;внутренних и наружных боковых зеркалах.</p>\n\n<p>При правостороннем движении в&nbsp;легковом автомобиле устанавливается зеркало заднего вида внутри салона и&nbsp;левое наружное боковое зеркало. Правое боковое обязательно, если зеркало заднего вида не&nbsp;может всегда обеспечивать нужный обзор, например когда заднее стекло занавешено шторками. Если же&nbsp;обзора через заднее окно вообще нет по&nbsp;конструкции автомобиля, зеркало заднего вида можно не ставить.</p>\n\n<p>Чтобы правильно установить боковые зеркала, поверните голову налево, посмотрите через окно и&nbsp;поворачивайте левое боковое зеркало (и&nbsp;остановитесь в&nbsp;тот момент), пока из&nbsp;него не&nbsp;пропадет изображение Вашего автомобиля.</p>\n\n<p>После этого поворачивайте голову к&nbsp;центру автомобиля и устанавливайте правое боковое зеркало, пока автомобиль не&nbsp;перестанет в нем отражаться.</p>\n\n<p>Боковые зеркала должны стоять так, чтобы три зеркала вместе давали Вам полный обзор окружающей обстановки. Слепых зон быть не должно.</p>\n\n<p><strong>Настраиваем зеркало заднего вида, необходимое для обзора дороги сзади и сбоку Вашей машины. </strong> Правильная настройка зеркала заднего вида очень важна. Центр правильно отрегулированного зеркала примерно должен совпадать с центром видимости в заднем стекле. В боковое зеркало водитель должен видеть бок собственного автомобиля, чтобы понимать положение других участников движения относительно своей машины. Такое отражение, однако, должно занимать в зеркале не более 2 см, иначе угол обзора будет очень ограничен. Линия горизонта должна находиться чуть ниже середины зеркала.</p>\n\n<p><strong>Как проверить общую настройку зеркал? </strong> Попросите кого-нибудь медленно обойти автомобиль вокруг на расстоянии около двух метров и сопровождайте такой обход взглядом в зеркала. Если отражение Вашего помощника пропадает в боковом зеркале и сразу же появляется в салонном (и наоборот), настройки выполнены правильно. Точно так же определяем, есть ли мёртвые зоны, где помощника не видим. Угол обзора можно увеличить, если немного наклониться к рулевому колесу.</p>\n\n<p>Источник: <a href="http://www.avtoobzor.info/articles/vozhdenie_automobilya/zerkala.html" rel="nofollow" target="_blank">http://www.avtoobzor.info/articles/vozhdenie_automobilya/zerkala.html</a></p>\n', '<p>referring to&nbsp;internal and external side mirrors.</p>\n\n<p>In right hand traffic in&nbsp;the car is installed the rear view mirror inside the cabin and&nbsp;exterior left side mirror. The right side is necessary if the rearview mirror is not&nbsp;able to provide own review, for example when back glass is curtained shutters. If&nbsp;vision through the rear window, no in&nbsp;the design of the car, the rearview mirror can not be set.</p>\n\n<p>to correctly set your side mirrors, turn your head left, look through the window and&nbsp;turn the left lateral mirror (and&nbsp;stay in&nbsp;the time) until&nbsp;not&nbsp;disappear the image of Your car.</p>\n\n<p>then rotate head to&nbsp;the center of vehicle and set right side mirror while the car is not&nbsp;will no longer be reflected in it.</p>\n\n<p>Lateral mirrors should stand so that three mirrors together give You a complete overview of the environment. Blind spots should not be.</p>\n\n<p><strong>Custom rear-view mirror necessary for the review of the road to the back and sides of Your machine. </strong> adjusting the rear view mirror is very important. The center of correctly adjusted mirror approximately should coincide with the visibility center in back glass. In a lateral mirror the driver should see the side of your own car, to understand position of other participants of movement relative to my car. Such reflection, however, must take in the mirror not more than 2 cm, otherwise the angle will be very limited. The horizon line should be slightly below the middle of the mirror.</p>\n\n<p><strong>How to check the overall settings of the mirrors? </strong> have someone slowly walk around the car around at a distance of about two meters and accompany this bypass with a look in the mirror. If reflection of Your assistant disappears in the rearview mirror and immediately appear in the cabin (and Vice versa), the settings are made correctly. Similarly define, whether there are dead zones where the assistant cannot see. The viewing angle can be increased a little closer to the steering wheel.</p>\n\n<p>Source: <a href="http://www.avtoobzor.info/articles/vozhdenie_automobilya/zerkala.html" rel="nofollow" target="_blank">http://www.avtoobzor.info/articles/vozhdenie_automobilya/zerkala.html</a></p>', '', '', '2016-02-04 10:14:15', 1, 1, 'Open Business Card - Настраиваем зеркала автомобиля', 'Open Business Card - Tune car mirrors', 'автомобильные зеркала, настройка', 'автомобильные зеркала, настройка', 'Настройка зеркал автомобиля', 'Настройка зеркал автомобиля'),
(2, 'Выбираем автомобильные шины', 'Choose car tires', '<p>Тот факт, что шины Вашего автомобиля чёрные и&nbsp;находятся внизу&nbsp;&mdash; ещё не&nbsp;повод, чтобы не&nbsp;обращать на&nbsp;них внимания. Полагаем, что Вам приходилось слышать об&nbsp;авариях и катастрофах, в&nbsp;которых именно шины и&nbsp;были &laquo;виноваты&raquo;. Конечно, не&nbsp;сами шины, а водители, но&nbsp;от&nbsp;этого не&nbsp;легче. Вне зависимости от того, покупаете ли&nbsp;Вы автомобиль&nbsp;&mdash; новый или подержанный&nbsp;&mdash; или давно сидите за&nbsp;рулём своего авто, на&nbsp;состояние покрышек надо постоянно обращать внимание. Шины должны быть качественными и&nbsp;надёжными.</p>\r\n\r\n<p>Главное &mdash; шины должны подходить к дискам колёс автомобиля. По этому поводу обычно есть рекомендации автозавода, их и надо соблюдать. Чрезвычайно желательно иметь одинаковые шины на всех четырёх колёсах (если автозавод не рекомендует иное). И в любом случае на одной оси автомобиля должны стоять шины одного типоразмера с одинаковым рисунком &mdash; это требование Правил дорожного движения!</p>\r\n\r\n<p>Общеизвестно понятие &laquo;сезонная резина&raquo; &mdash; летняя или зимняя. Зимние шины бывают с шипами, затрудняющими скольжение, или без них. Маркируются они чаще буквами латинского алфавита M+S, что означает &laquo;грязь+снег&raquo;. На шипованных шинах лучше ездить за городом, где дороги не очищены и вообще далеко не комфортные. На городском асфальте можно ездить на нешипованных, даже если поверх асфальта каша из снега и соли. Летняя резина, естественно, предназначена для остальных сезонов.</p>\r\n\r\n<p>Выпускаются всесезонные шины, которые маркируются AS (All Seasons &mdash; все сезоны) или AW (Any Weather &mdash; (любая погода). Эти шины уступают специализированным, сложнее в производстве и стоят значительно дороже сезонных. Они, так сказать, для лентяев.</p>\r\n\r\n<p>Автошины делятся на диагональные и радиальные, камерные и бескамерные. Радиальные мягче и комфортабельнее диагональных. У них меньше сопротивление качению, что снижает расход топлива. Их управляемость значительно лучше, а срок службы заметно дольше. Однако они слабее, чем диагональные, переносят удары и порезы и недостаточно прочны на плохих дорогах. Радиальные шины лучше для езды по шоссе.</p>\r\n\r\n<p>Автомобильные шины, которые Вы покупаете, должны соответствовать российским и международным стандартам. Сертифицированные шины имеют маркировку Е (это соответствие европейским стандартам), DOT (американским) или и ту и другую.</p>\r\n\r\n<p>Как и в отношении любого товара, можно говорить о брендах с мировой известностью (Dunlop, Kleber, Matador, Michelin, Nokian, Pirelli) и о продукции менее известных предприятий. Абсолютно ясно, что качество купленных вами шин напрямую определяет потенциальную опасность попасть в аварию. Безопасность Вашей жизни, в конце концов, самое главное.</p>\r\n\r\n<p>Источник: <a href="http://avtoobzor.info/articles/obsluzhivanie_avtomobilya/avtomobilniye-shiny.html" rel="nofollow" target="_blank">http://avtoobzor.info/articles/obsluzhivanie_avtomobilya/avtomobilniye-shiny.html</a></p>\r\n', '<p>The fact that your car tires are black and & nbsp; at the bottom of & nbsp; & mdash; yet & nbsp; an excuse not to & nbsp; to pay & nbsp; their attention. We believe that you have heard about the & nbsp; accidents and catastrophes in the & nbsp; which is tires and & nbsp; were & laquo; guilty & raquo ;. Of course, not & nbsp; own tires and drivers, but & nbsp; on & nbsp; not & nbsp; easier. Regardless of whether you are buying a & nbsp; You Vehicles & nbsp; & mdash; new or used & nbsp; & mdash; or sit for a long time & nbsp; the wheel of his car on & nbsp; the condition of tires must constantly pay attention. The tires must be of high quality and & nbsp; reliable. </ P>\n\n<p> Home & mdash; the tire should approach drives the wheels of the car. In this regard, there is usually a recommendation automobile, and they must be respected. It is extremely desirable to have the same tires on all four wheels (if car factory does not recommend otherwise). And in any case on the same axle of a vehicle must be tires of the same size with the same pattern & mdash; This requirement of traffic rules! </ p>\n\n<p> It is well known concept of & laquo; Seasonal tires & raquo; & mdash; summer or winter. Winter tires are studded hampering sliding, or without them. They are often marked with the Latin letters M + S, which means & laquo; mud + snow & raquo ;. On studded tires better ride out of town, where the roads are not cleaned and generally far from comfortable. At the city asphalt can be driven on non-studded, even if on top of asphalt mess of snow and salt. Summer tires, of course, is for the rest of season. </ P>\n\n<p> Available in all-season tires that are marked AS (All Seasons & mdash; all seasons) or AW (Any Weather & mdash; (any weather). These tires are inferior to the specialized, difficult to manufacture and cost significantly more seasonal. They are, so to speak, for lazy. </ p>\n\n<p> Tires are divided into bias and radial, tube and tubeless. Radial softer and more comfortable than the diagonal. They have less rolling resistance, which reduces fuel consumption. Their handling is much better and much longer service life. However, they are weaker than the diagonal, tolerate blows and cuts, and not strong enough on bad roads. Radial tires are better for driving on the highway. </ P>\n\n<p> Tires that you buy must comply with Russian and international standards. Certified tires are labeled E (corresponding to European standards), DOT (US), or one and the other. </ P>\n\n<p> As with any product, you can talk about the world-famous brands (Dunlop, Kleber, Matador, Michelin, Nokian, Pirelli) and of products of lesser-known companies. It is absolutely clear that the quality of tires you purchased directly determines the potential danger of an accident. Security of your life, in the end, the most important thing. </ P>\n\n<p> Source: <a href = "http://avtoobzor.info/articles/obsluzhivanie_avtomobilya/avtomobilniye-shiny.html" rel = "nofollow" target="_blank">http://avtoobzor.info/articles/obsluzhivanie_avtomobilya/avtomobilniye-shiny.html</a></p>', '', '', '2016-02-02 10:26:44', 1, 2, 'Open Business Card - Выбираем автомобильные шины', 'Open Business Card - Choose car tires', 'автомобильные шины', 'car tyres', 'Выбираем автомобильные шины', 'Choose car tires'),
(3, 'Если заменяем колёса…', 'If you replace the wheels.', '<p>Главное &mdash; не следует это делать без необходимости. Если винты откручивать и закручивать, да еще без динамометрического ключа, диски колёс просто деформируются. Основная рекомендация &mdash; ездить, пока передние колёса не будут близки к предельному износу.</p>\n\n<p>Однако может статься, это Вам потребовалось внезапно и вдруг. Что надо иметь в этом случае? Конечно, само запасное колесо, домкрат, баллонный ключ, дощечку для подставки под домкрат, противооткатные упоры (два бруска-клина), насос с манометром и пару перчаток.</p>\n\n<p>Найдите ровный участок дороги в безопасном месте (на проезжей части &mdash; только в более чем крайнем случае!) Помните о правилах техники безопасности!</p>\n\n<p>Работать надо аккуратно &mdash; если, к примеру, бросать болты и гайки на землю, в резьбу забьётся грязь. Найдите для них чистую тару. Если запасное или снятое колесо прислонить к машине &mdash; оно может упасть в самый неподходящий момент и причинить неприятности.</p>\n\n<p>Вроде бы всё ясно и просто - отвернул-заменил-завернул-поехали. Однако при этом нетрудно и автомобиль повредить (помять пороги и не только). И себе нанести травму.</p>\n\n<p><strong>Каков порядок действий при замене колеса?</strong> Включаем первую передачу, затягиваем стояночный тормоз и под колеса с противоположной стороны автомобиля подкладываем клинья-упоры. Их надо слегка дослать молотком для большей страховки от перемещения автомобиля.</p>\n\n<p>Берём запасное колесо, кладём его на землю, ослабляем гайки заменяемого колеса. Устанавливаем домкрат под небольшим углом на подставку для увеличения площади опоры, чтобы домкрат не вдавился в грунт.</p>\n\n<p>Приподнимаем автомобиль домкратом, отворачиваем гайки крепления, снимаем колесо и кладём его на землю. Последней отворачиваем гайку (болт), находящуюся на вершине круга.</p>\n\n<p>Снимаем колесо, слегка приподнимая его двумя руками с боков ниже средней линии. Руки не должны при этом быть между колесом и дорогой или кузовом &mdash; возможна травма!</p>\n\n<p>Ставим запасное колесо, сначала наживляем верхнюю гайку (болт), затем остальные. Затягиваем ключом (насколько возможно) гайки (болты) крепления, но не по кругу, а крест-накрест! Только такая последовательность обеспечит правильную центровку колеса.</p>\n\n<p>Опускаем машину на землю и окончательно подтягиваем гайки (болты). Убираем снятое колесо и клинья из-под колес.</p>\n\n<p>Проверяем давление в камере и при необходимости подкачиваем ее до номинальной величины, которая указана в техническом описании автомобиля.</p>\n\n<p>Проверяем ниппель камеры на герметичность, потом заворачиваем его колпачок.</p>\n\n<p>Источник: <a href="http://avtoobzor.info/articles/obsluzhivanie_avtomobilya/zamena-koles.html" rel="nofollow" target="_blank">http://avtoobzor.info/articles/obsluzhivanie_avtomobilya/zamena-koles.html</a></p>\n', '<p>most Importantly &mdash; not should do without having. If the screws loosen and tighten, even without a torque wrench, the wheels just deformed. The main recommendation &mdash; to drive until the front wheels are close to the limit of wear.</p>\n\n<p>However, perhaps it took You suddenly and suddenly. What should I keep in this case? Of course, the spare wheel, Jack, wheel wrench, plate for under the Jack stand, wheel chocks (two bars-wedge), pump with gauge and a pair of gloves.</p>\n\n<p>Find a flat stretch of road in a safe place (on the road &mdash; only in a more than a pinch!) Remember the safety rules!</p>\n\n<p>it is necessary to Work carefully &mdash; if, for example, throw the bolts and nuts on the ground, the thread will become clogged dirt. Look for them in a clean container. If captured or spare wheel to lean to the car &mdash; it may fall at the most inopportune moment and cause trouble.</p>\n\n<p>everything Seems to be clear and just - turned-replaced-wrapped-go. However, it is easy and the car damage (dent rapids and not only). Yourself and cause injury.</p>\n\n<p><strong>What is the procedure when changing the wheel?</strong> Include first gear, tighten the Parking brake and under wheels from an opposite side of the car puts wedges-emphasis. They need slightly provide the hammer for greater insurance from the moving car.</p>\n\n<p>Take the spare tire, put it on the ground, weakening the nut steering wheel. Set the Jack at a slight angle on the stand to increase the area of support that the Jack was not pressed into the soil.</p>\n\n<p>Raise the car a Jack, turn away a nut of fastening, remove the wheel and put it on the ground. Last we turn on the nut (bolt) at the top of the circle.</p>\n\n<p>we Remove a wheel, slightly raising his two hands from the sides below the middle line. Hands should not be between the wheel and the road or a body &mdash; possible injury!</p>\n\n<p>Put the spare wheel, first najavljen top nut (bolt), then the other. Tighten the key (as possible) the nuts (bolts) fixing, but not in a circle, and criss-cross! Only such sequence will ensure proper wheel alignment.</p>\n\n<p>Lower the car to the ground and finally tightens the nuts (bolts). Clean the removed wheel and the wedges from under the wheels.</p>\n\n<p>Check the pressure in the chamber and if necessary pumped up to its nominal value indicated in the technical description of the vehicle.</p>\n\n<p>Check the nipple chamber for leaks, then turning his cap.</p>\n\n<p>Source: <a href="http://avtoobzor.info/articles/obsluzhivanie_avtomobilya/zamena-koles.html" rel="nofollow" target="_blank">http://avtoobzor.info/articles/obsluzhivanie_avtomobilya/zamena-koles.html</a></p>', '', '', '2016-02-04 10:14:41', 1, 3, 'Open Business Card - Если заменяем колёса…', 'Open Business Card - If you replace the wheels...', 'колесё, замена', 'kolesë, replacement', 'Замена колёс', 'Replacement wheels');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}catalog`
--

DROP TABLE IF EXISTS `{dbPrefix}catalog`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` smallint(2) NOT NULL,
  `id_sub_category` int(11) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_en` text NOT NULL,
  `description_ru` text NOT NULL,
  `description_en` text NOT NULL,
  `cost_ru` varchar(255) NOT NULL,
  `cost_en` varchar(255) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sorter` int(11) NOT NULL,
  `seo_title_ru` varchar(255) NOT NULL,
  `seo_title_en` varchar(255) NOT NULL,
  `seo_keywords_ru` text NOT NULL,
  `seo_keywords_en` text NOT NULL,
  `seo_description_ru` text NOT NULL,
  `seo_description_en` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`),
  KEY `id_category` (`id_category`),
  KEY `id_sub_category` (`id_sub_category`),
  FULLTEXT KEY `title` (`title_ru`),
  FULLTEXT KEY `description` (`description_ru`),
  FULLTEXT KEY `cost` (`cost_ru`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `{dbPrefix}catalog`
--

INSERT INTO `{dbPrefix}catalog` (`id`, `id_category`, `id_sub_category`, `title_ru`, `title_en`, `description_ru`, `description_en`, `cost_ru`, `cost_en`, `date_updated`, `active`, `sorter`, `seo_title_ru`, `seo_title_en`, `seo_keywords_ru`, `seo_keywords_en`, `seo_description_ru`, `seo_description_en`) VALUES
(1, 1, 1, 'Audi A4', 'Audi A4', '<table class="form item-description" width="100%">\r\n	<tbody>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Марка топлива:</td>\r\n			<td class="second">\r\n				дизельное топливо</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Объем двигателя, куб. см.:</td>\r\n			<td class="second">\r\n				1968</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Мощность, л.с.:</td>\r\n			<td class="second">\r\n				120</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Достигается при об. в мин.:</td>\r\n			<td class="second">\r\n				4200</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Максимальная скорость, км/ч:</td>\r\n			<td class="second">\r\n				205</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Время разгона до 100 км/ч, сек.:</td>\r\n			<td class="second">\r\n				10.7</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Расход топлива (смешанный цикл), л. на 100 км.:</td>\r\n			<td class="second">\r\n				5.1</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Коэффициент сжатия:</td>\r\n			<td class="second">\r\n				16.5</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n', '<table class="form item-description" Width="100%">\r\n<tbody>\r\nthe <Tr>\r\n<TD class="first" Width="60%">\r\nFuel grade:</TD>\r\n<TD class="second">\r\ndiesel fuel</TD>\r\n</th>\r\n<Tr class="grey">\r\n<TD class="first" Width="60%">\r\nEngine capacity, CC:</TD>\r\n<TD class="second">\r\n1968</TD>\r\n</th>\r\n<Tr class="grey">\r\n<TD class="first" Width="60%">\r\nPower, HP:</TD>\r\n<TD class="second">\r\n120</TD>\r\n</th>\r\nthe <Tr>\r\n<TD class="first" Width="60%">\r\nIs reached at about. in minutes:</TD>\r\n<TD class="second">\r\n4200</TD>\r\n</th>\r\nthe <Tr>\r\n<TD class="first" Width="60%">\r\nMaximum speed, km/h:</TD>\r\n<TD class="second">\r\n205</TD>\r\n</th>\r\n<Tr class="grey">\r\n<TD class="first" Width="60%">\r\nAcceleration to 100 km/CH, sec.:</TD>\r\n<TD class="second">\r\n10.7</TD>\r\n</th>\r\nthe <Tr>\r\n<TD class="first" Width="60%">\r\nFuel consumption (mixed cycle), l / 100 km:</TD>\r\n<TD class="second">\r\n5.1</TD>\r\n</th>\r\nthe <Tr>\r\n<TD class="first" Width="60%">\r\nAspect ratio:</TD>\r\n<TD class="second">\r\n16.5</TD>\r\n</th>\r\n</tbody>\r\n</table>', 'от 1 200 000 рублей', 'from $ 40 000', '2016-02-03 13:56:01', 1, 1, '', '', 'Audi A4', 'Audi A4', 'Audi A4', 'Audi A4'),
(2, 2, 3, 'Mazda 6', 'Mazda 6', '<table class="form item-description" width="100%">\r\n	<tbody>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Объем двигателя, куб. см.:</td>\r\n			<td class="second">\r\n				2000</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Мощность, л.с.:</td>\r\n			<td class="second">\r\n				147</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Достигается при об. в мин.:</td>\r\n			<td class="second">\r\n				6500</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Максимальная скорость, км/ч:</td>\r\n			<td class="second">\r\n				215</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Время разгона до 100 км/ч, сек.:</td>\r\n			<td class="second">\r\n				10</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Расход топлива (смешанный цикл), л. на 100 км.:</td>\r\n			<td class="second">\r\n				7</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Расход топлива (в городе), л. на 100 км.:</td>\r\n			<td class="second">\r\n				9.8</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Расход топлива (за городом), л. на 100 км.:</td>\r\n			<td class="second">\r\n				5.4</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	Mazda 6 (в связи с ограничениями на использование цифр в торговых марках автомобилей применяется слитное написание Mazda6) &mdash; автомобиль японской компании Mazda. Выпускается с 2002 года. В Японии продается под названием Mazda Atenza.<span id="pastemarkerend">&nbsp;</span></p>\r\n', '<table class="form-item-description" width="100%">\n<tbody>\n<tr class="gray">\n<td class="first" width="60%">\nEngine capacity, CC:</td>\n<td class="second">\n2000</td>\n</tr>\nthe <tr>\n<td class="first" width="60%">\nPower, HP:</td>\n<td class="second">\n147</td>\n</tr>\n<tr class="gray">\n<td class="first" width="60%">\nIs reached at about. in minutes:</td>\n<td class="second">\n6500</td>\n</tr>\n<tr class="gray">\n<td class="first" width="60%">\nMaximum speed, km/h:</td>\n<td class="second">\n215</td>\n</tr>\nthe <tr>\n <td class="first" width="60%">\nAcceleration to 100 km/CH, sec.:</td>\n<td class="second">\n10</td>\n</tr>\n<tr class="gray">\n<td class="first" width="60%">\nFuel consumption (mixed cycle), l / 100 km:</td>\n<td class="second">\n7</td>\n</tr>\nthe <tr>\n<td class="first" width="60%">\nFuel consumption (in town), l / 100 km:</td>\n<td class="second">\n9.8</td>\n</tr>\n<tr class="gray">\n<td class="first" width="60%">\nFuel consumption (extra-urban), l. 100 km.:</td>\n<td class="second">\n5.4</td>\n</tr>\n</tbody>\n</table>\n<p>\n Mazda 6 (due to restrictions on the use of digits in the trademark hire applies continuous writing Mazda6) &mdash; the car of the Japanese company Mazda. Produced since 2002. Sold in Japan under the name Mazda Atenza.<span id="pastemarkerend">&nbsp;</span></p>', 'от 800 000 рублей', 'from $ 26 500', '2016-02-03 13:56:01', 1, 2, '', '', 'Mazda 6', 'Mazda 6', 'Mazda 6', 'Mazda 6'),
(3, 2, 2, 'Mazda 3', 'Mazda 3', '\r\n<table class="form item-description" width="100%">\r\n\r\n<tbody>\r\n\r\n	<tr class="gray">\r\n\r\n		<td class="first" width="60%">Объем двигателя, куб. см.:</td>\r\n\r\n\r\n		<td class="second">1999</td>\r\n\r\n	</tr>\r\n\r\n\r\n	<tr>\r\n\r\n		<td class="first" width="60%">Мощность, л.с.:</td>\r\n\r\n\r\n		<td class="second">150</td>\r\n\r\n	</tr>\r\n\r\n\r\n	<tr class="gray">\r\n\r\n		<td class="first" width="60%">Достигается при об. в мин.:</td>\r\n\r\n\r\n		<td class="second">6000</td>\r\n\r\n	</tr>\r\n\r\n\r\n	<tr class="gray">\r\n\r\n		<td class="first" width="60%">Максимальная скорость, км/ч:</td>\r\n\r\n\r\n		<td class="second">209</td>\r\n\r\n	</tr>\r\n\r\n\r\n	<tr>\r\n\r\n		<td class="first" width="60%">Расход топлива (смешанный цикл), л. на 100 км.:</td>\r\n\r\n\r\n		<td class="second">7.9</td>\r\n\r\n	</tr>\r\n\r\n\r\n	<tr class="gray">\r\n\r\n		<td class="first" width="60%">Расход топлива (в городе), л. на 100 км.:</td>\r\n\r\n\r\n		<td class="second">10.6</td>\r\n\r\n	</tr>\r\n\r\n\r\n	<tr>\r\n\r\n		<td class="first" width="60%">Расход топлива (за городом), л. на 100 км.:</td>\r\n\r\n\r\n		<td class="second">6.4</td>\r\n\r\n	</tr>\r\n\r\n</tbody>\r\n\r\n</table>\r\n\r\nНебольшой автомобиль, производимый Mazda Motor Corporation в Японии. На родине производителя он называется Mazda Axela.<span id="pastemarkerend">&nbsp;</span>', '<table class="form-item-description" width="100%">\r\n\r\n<tbody>\r\n\r\n<tr class="gray">\r\n\r\n<td class="first" width="60%">engine capacity, CC:</td>\r\n\r\n\r\n<td class="second">1999</td>\r\n\r\n</tr>\r\n\r\n\r\nthe <tr>\r\n\r\n<td class="first" width="60%">Power BHP:</td>\r\n\r\n\r\n<td class="second">150</td>\r\n\r\n</tr>\r\n\r\n\r\n<tr class="gray">\r\n\r\n<td class="first" width="60%">Achieved at about. in minutes:</td>\r\n\r\n\r\n<td class="second">6000</td>\r\n\r\n</tr>\r\n\r\n\r\n<tr class="gray">\r\n\r\n<td class="first" width="60%">Maximum speed, km/h:</td>\r\n\r\n\r\n<td class="second">209</td>\r\n\r\n</tr>\r\n\r\n\r\nthe <tr>\r\n\r\n <td class="first" width="60%">fuel Consumption (mixed cycle), l / 100 km:</td>\r\n\r\n\r\n<td class="second">7.9</td>\r\n\r\n</tr>\r\n\r\n\r\n<tr class="gray">\r\n\r\n<td class="first" width="60%">fuel Consumption (in town), l / 100 km:</td>\r\n\r\n\r\n<td class="second">10.6</td>\r\n\r\n</tr>\r\n\r\n\r\nthe <tr>\r\n\r\n<td class="first" width="60%">fuel Consumption (extra-urban), l. 100 km.:</td>\r\n\r\n\r\n<td class="second">6.4</td>\r\n\r\n</tr>\r\n\r\n</tbody>\r\n\r\n</table>\r\n\r\nA small car manufactured by Mazda Motor Corporation in Japan. At home manufacturer it''s called Mazda Axela.<span id="pastemarkerend">&nbsp;</span>\r\n\r\nУстановите приложение на смартфон и работайте офлайн\r\n\r\nПер', 'от 650 000 рублей', 'from $ 21 500', '2016-02-03 13:56:01', 1, 3, '', '', 'Mazda 3', 'Mazda 3', 'Mazda 3', 'Mazda 3'),
(4, 3, 4, 'Mitsubishi Lancer', 'Mitsubishi Lancer', '<table class="form item-description" width="100%">\r\n	<tbody>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Марка топлива:</td>\r\n			<td class="second">\r\n				АИ-95</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Объем двигателя, куб. см.:</td>\r\n			<td class="second">\r\n				1798</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Мощность, л.с.:</td>\r\n			<td class="second">\r\n				143</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Достигается при об. в мин.:</td>\r\n			<td class="second">\r\n				6000</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Максимальная скорость, км/ч:</td>\r\n			<td class="second">\r\n				204</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Время разгона до 100 км/ч, сек.:</td>\r\n			<td class="second">\r\n				9.8</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Расход топлива (смешанный цикл), л. на 100 км.:</td>\r\n			<td class="second">\r\n				7.7</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Диaметр цилиндра, мм:</td>\r\n			<td class="second">\r\n				86</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Коэффициент сжатия:</td>\r\n			<td class="second">\r\n				10</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	Спортивный, заметный автомобиль от знаменитого производителя. Зажги ночь, будь ярким!</p>\r\n', '<table class="form-item-description" width="100%">\r\n<tbody>\r\nthe <tr>\r\n<td class="first" width="60%">\r\nFuel grade:</td>\r\n<td class="second">\r\nAI-95</td>\r\n</tr>\r\n<tr class="gray">\r\n<td class="first" width="60%">\r\nEngine capacity, CC:</td>\r\n<td class="second">\r\n1798</td>\r\n</tr>\r\n<tr class="gray">\r\n<td class="first" width="60%">\r\nPower, HP:</td>\r\n<td class="second">\r\n143</td>\r\n</tr>\r\nthe <tr>\r\n<td class="first" width="60%">\r\nIs reached at about. in minutes:</td>\r\n<td class="second">\r\n6000</td>\r\n</tr>\r\nthe <tr>\r\n<td class="first" width="60%">\r\n Maximum speed, km/h:</td>\r\n<td class="second">\r\n204</td>\r\n</tr>\r\n<tr class="gray">\r\n<td class="first" width="60%">\r\nAcceleration to 100 km/CH, sec.:</td>\r\n<td class="second">\r\n9.8</td>\r\n</tr>\r\nthe <tr>\r\n<td class="first" width="60%">\r\nFuel consumption (mixed cycle), l / 100 km:</td>\r\n<td class="second">\r\n7.7</td>\r\n</tr>\r\nthe <tr>\r\n<td class="first" width="60%">\r\nDiameter of cylinder, mm:</td>\r\n<td class="second">\r\n86</td>\r\n</tr>\r\n<tr class="gray">\r\n<td class="first" width="60%">\r\nAspect ratio:</td>\r\n<td class="second">\r\n10</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>\r\nSports, a marked car from the famous manufacturer. Light up the night, be bright!</p>\r\n\r\n', 'от 680 000 рублей', 'from $ 22 500', '2016-02-03 13:56:01', 1, 4, '', '', 'Mitsubishi Lancer', 'Mitsubishi Lancer', 'Mitsubishi Lancer', 'Mitsubishi Lancer'),
(5, 4, 5, 'Toyota Camry', 'Toyota Camry', '<table class="form item-description" width="100%">\r\n	<tbody>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Тип двигателя:</td>\r\n			<td class="second">\r\n				V6</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Марка топлива:</td>\r\n			<td class="second">\r\n				АИ-95</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Объем двигателя, куб. см.:</td>\r\n			<td class="second">\r\n				2994</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Мощность, л.с.:</td>\r\n			<td class="second">\r\n				215</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Достигается при об. в мин.:</td>\r\n			<td class="second">\r\n				5800</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Максимальная скорость, км/ч:</td>\r\n			<td class="second">\r\n				225</td>\r\n		</tr>\r\n		<tr class="gray">\r\n			<td class="first" width="60%">\r\n				Время разгона до 100 км/ч, сек.:</td>\r\n			<td class="second">\r\n				9.1</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Расход топлива (смешанный цикл), л. на 100 км.:</td>\r\n			<td class="second">\r\n				11</td>\r\n		</tr>\r\n		<tr>\r\n			<td class="first" width="60%">\r\n				Коэффициент сжатия:</td>\r\n			<td class="second">\r\n				10.5</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	Прекрасное сочетание цены, качества и стиля! Быстрый, современный и надежный автомобиль от ведущего мирового производителя.</p>\r\n', '<table class="form-item-description" width="100%">\r\n<tbody>\r\n<tr class="gray">\r\n<td class="first" width="60%">\r\nEngine type:</td>\r\n<td class="second">\r\nV6</td>\r\n</tr>\r\nthe <tr>\r\n<td class="first" width="60%">\r\nFuel grade:</td>\r\n<td class="second">\r\nAI-95</td>\r\n</tr>\r\n<tr class="gray">\r\n<td class="first" width="60%">\r\nEngine capacity, CC:</td>\r\n<td class="second">\r\n2994</td>\r\n</tr>\r\n<tr class="gray">\r\n<td class="first" width="60%">\r\nPower, HP:</td>\r\n<td class="second">\r\n215</td>\r\n</tr>\r\nthe <tr>\r\n<td class="first" width="60%">\r\n Is reached at about. in minutes:</td>\r\n<td class="second">\r\n5800</td>\r\n</tr>\r\nthe <tr>\r\n<td class="first" width="60%">\r\nMaximum speed, km/h:</td>\r\n<td class="second">\r\n225</td>\r\n</tr>\r\n<tr class="gray">\r\n<td class="first" width="60%">\r\nAcceleration to 100 km/CH, sec.:</td>\r\n<td class="second">\r\n9.1</td>\r\n</tr>\r\nthe <tr>\r\n<td class="first" width="60%">\r\nFuel consumption (mixed cycle), l / 100 km:</td>\r\n<td class="second">\r\n11</td>\r\n</tr>\r\nthe <tr>\r\n<td class="first" width="60%">\r\nAspect ratio:</td>\r\n<td class="second">\r\n10.5</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>\r\nA perfect combination of price, quality and style! Fast, modern and reliable car the world''s leading producer.</p>', 'от 1 000 000 рублей', 'from $ 33 000', '2016-02-03 13:56:01', 1, 5, '', '', 'Toyota Camry', 'Toyota Camry', 'Toyota Camry', 'Toyota Camry');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}catalog_category`
--

DROP TABLE IF EXISTS `{dbPrefix}catalog_category`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}catalog_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_ru` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sorter` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `{dbPrefix}catalog_category`
--

INSERT INTO `{dbPrefix}catalog_category` (`id`, `title_ru`, `title_en`, `date_updated`, `active`, `sorter`) VALUES
(1, 'Audi', 'Audi', '2016-02-03 12:18:38', 1, 1),
(2, 'Mazda', 'Mazda', '2016-02-03 12:18:38', 1, 2),
(3, 'Mitsubishi', 'Mitsubishi', '2016-02-03 12:18:38', 1, 3),
(4, 'Toyota', 'Toyota', '2016-02-03 12:18:38', 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}catalog_images`
--

DROP TABLE IF EXISTS `{dbPrefix}catalog_images`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}catalog_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `sorter` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `date_updated` (`date_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `{dbPrefix}catalog_images`
--

INSERT INTO `{dbPrefix}catalog_images` (`id`, `pid`, `img`, `sorter`, `active`, `date_updated`) VALUES
(1, 1, '25e3cebaa9f740c9749399521aa2dae4.png', 2, 1, '2014-03-06 13:00:41'),
(2, 2, '45bba8e0156faff55aed72810a61f414.png', 1, 1, '2012-06-19 09:00:00'),
(3, 3, '77f0b6f250a4d0e12b85661368b9b079.png', 1, 1, '2012-06-19 09:00:00'),
(4, 4, '6363c66ee2ae25fff833d0503bc445fb.png', 3, 1, '2013-03-30 13:10:41'),
(5, 5, 'c2ba978353d8de567bc4feb9b74a04aa.png', 1, 1, '2012-06-19 09:00:00'),
(6, 1, '1_1e1a577a90e4d66aa78c95b902d18ae2.jpg', 3, 1, '2013-03-30 13:03:24'),
(7, 1, '1_0e69eb5b4b164daddc3be973fdae2f56.jpg', 1, 1, '2013-03-30 13:03:25'),
(8, 1, '1_7d2a04132861bdd8922d5fc435e0064b.jpg', 4, 1, '2013-03-30 13:03:07'),
(9, 2, '2_930c8d078dafb3ee6b044789610f7c6e.jpg', 2, 1, '2013-03-30 13:06:41'),
(10, 4, '4_bcc77a60ca9825329649fe514a24d611.jpg', 1, 1, '2013-03-30 13:10:39'),
(11, 4, '4_eb6cd3d94219636f078bf2232420cad3.jpg', 2, 1, '2013-03-30 13:10:41'),
(12, 5, '5_e5c50e4c9643e5f937cad6321a35b69a.jpg', 2, 1, '2013-03-30 13:12:42');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}catalog_item_category`
--

DROP TABLE IF EXISTS `{dbPrefix}catalog_item_category`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}catalog_item_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`),
  KEY `id_item` (`id_item`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `{dbPrefix}catalog_item_category`
--

INSERT INTO `{dbPrefix}catalog_item_category` (`id`, `id_item`, `id_category`, `date_updated`) VALUES
(1, 1, 1, '2012-09-03 04:05:10'),
(2, 2, 2, '2012-09-03 04:25:44'),
(3, 3, 2, '2012-09-03 04:25:44'),
(4, 4, 3, '2012-09-03 04:25:44'),
(5, 5, 4, '2012-09-03 04:25:44');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}catalog_sub_category`
--

DROP TABLE IF EXISTS `{dbPrefix}catalog_sub_category`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}catalog_sub_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sorter` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `{dbPrefix}catalog_sub_category`
--

INSERT INTO `{dbPrefix}catalog_sub_category` (`id`, `id_category`, `title_ru`, `title_en`, `date_updated`, `active`, `sorter`) VALUES
(1, 1, 'A4', 'A4', '2016-02-03 12:18:49', 1, 1),
(2, 2, 'Mazda 3', 'Mazda 3', '2016-02-03 12:18:49', 1, 2),
(3, 2, 'Mazda 6', 'Mazda 6', '2016-02-03 12:18:49', 1, 3),
(4, 3, 'Lancer', 'Lancer', '2016-02-03 12:18:49', 1, 4),
(5, 4, 'Camry', 'Camry', '2016-02-03 12:18:49', 1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}configuration`
--

DROP TABLE IF EXISTS `{dbPrefix}configuration`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('bool','text','enum','hidden') NOT NULL,
  `section` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL DEFAULT '',
  `title_en` varchar(255) NOT NULL,
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Дамп данных таблицы `{dbPrefix}configuration`
--

INSERT INTO `{dbPrefix}configuration` (`id`, `type`, `section`, `name`, `value`, `title_ru`, `title_en`, `date_updated`) VALUES
(1, 'text', 'Кэш', 'cachingTime', '3600', 'Время кеширования объектов (в секундах)', 'Objects cache time (in seconds)', '2011-11-26 17:01:21'),
(2, 'text', 'Новости', 'newsModule_truncateAfterWords', '10', 'Новости. Обрезать текст статьи и добавлять ссылку "Читать далее" после ... слов (0 - не обрезать)', 'News. To cut off the text of news and to add the link "Read more" after ... words (0 - not to cut off)', '2011-03-30 17:01:21'),
(3, 'text', 'Новости', 'module_news_itemsPerPage', '10', 'Элементов на страницу в разделе "Новости"', 'Number of news per page in the section "News"', '0000-00-00 00:00:00'),
(4, 'text', 'Контакты', 'adminEmail', '{adminEmail}', 'E-mail администратора', 'E-mail of the administrator', '0000-00-00 00:00:00'),
(5, 'text', 'Контакты', 'adminPhone', '+7 (111) 111 1111', 'Контактный телефон', 'Phone number', '0000-00-00 00:00:00'),
(6, 'text', 'Контакты', 'adminSkype', 'monoray.studio', 'Skype', 'Skype', '0000-00-00 00:00:00'),
(7, 'text', 'Контакты', 'adminICQ', '616147066', 'ICQ', 'ICQ', '0000-00-00 00:00:00'),
(8, 'text', 'Контакты', 'adminAddress', '424000, г. Йошкар-Ола', 'Адрес', 'Address', '0000-00-00 00:00:00'),
(9, 'text', 'Статьи', 'module_articles_itemsPerPage', '10', 'Статей на страницу в разделе "Статьи"', 'Number of articles per page in the section "Articles"', '0000-00-00 00:00:00'),
(10, 'text', 'Статьи', 'module_articles_truncateAfterWords', '10', 'Статьи. Обрезать текст статьи и добавлять ссылку "Читать далее" после ... слов (0 - не обрезать)', 'News. To cut off the text of article and to add the link "Read more" after ... words (0 - not to cut off)', '0000-00-00 00:00:00'),
(15, 'text', 'Главные', 'adminPaginationPageSize', '20', 'Панель администратора: количество элементов для табличного отображения', 'Dashboard: quantity of elements for tabular display', '0000-00-00 00:00:00'),
(16, 'bool', 'Главные', 'useUrlTranslit', '1', 'Использовать транслитерацию url', 'Use URL transliteration', '2012-04-17 17:01:21'),
(17, 'text', 'Галерея', 'maxWidthBigThumb', '800', 'Галерея. Максимальная ширина фотографии после загрузки', 'Gallery. Maximum width for gallery photos after upload', '2011-11-26 17:01:21'),
(18, 'text', 'Галерея', 'maxHeightBigThumb', '600', 'Галерея. Максимальная высота фотографии после загрузки', 'Gallery. Maximum height for gallery photos after upload', '2011-11-26 17:01:21'),
(19, 'text', 'Галерея', 'maxWidthMediumThumb', '436', 'Максимальная ширина фотографии, отображаемой в "Галерее"', 'Gallery. Max width of gallery image', '2011-11-26 17:01:21'),
(20, 'text', 'Галерея', 'maxHeightMediumThumb', '273', 'Максимальная высота фотографии, отображаемой в "Галерее"', 'Gallery. Max heigth of gallery image', '2011-11-26 17:01:21'),
(21, 'text', 'Галерея', 'maxWidthSmallThumb', '100', 'Максимальная ширина превьюшки к фотографии после загрузки', 'Gallery. Max width of thumbnail image', '2011-11-26 17:01:21'),
(22, 'text', 'Галерея', 'maxHeightSmallThumb', '75', 'Максимальная высота превьюшки к фотографии после загрузки', 'Gallery. Max height of thumbnail image', '2011-11-26 17:01:21'),
(23, 'text', 'Галерея', 'module_gallery_itemsPerPage', '6', 'Элементов на страницу в разделе "Галерея"', 'Gallery. Number of elements per page in the section "Gallery"', '0000-00-00 00:00:00'),
(24, 'text', 'Прайс-лист', 'module_price_itemsPerPage', '50', 'Количество записей на одной странице в разделе "Прайс-лист"', 'Number of elements per page in the section "Price"', '2012-04-02 17:01:21'),
(25, 'text', 'Каталог', 'maxWidthMediumThumbCatalog', '436', 'Максимальная ширина фотографии, отображаемой в "Каталоге товаров"', 'Catalog. Max width of catalog image', '2012-04-05 17:01:21'),
(26, 'text', 'Каталог', 'maxHeightMediumThumbCatalog', '273', 'Максимальная высота фотографии, отображаемой в "Каталоге товаров"', 'Catalog. Max height of catalog image', '2012-04-05 17:01:21'),
(27, 'text', 'Каталог', 'maxWidthSmallThumbCatalog', '100', 'Максимальная ширина превьюшки к фотографии после Каталоге товаров', 'Catalog. Max width of thumbnail image', '2012-04-05 17:01:21'),
(28, 'text', 'Каталог', 'maxHeightSmallThumbCatalog', '75', 'Максимальная высота превьюшки к фотографии после Каталоге товаров', 'Catalog. Max height of thumbnail image', '2012-04-05 17:01:21'),
(29, 'text', 'Каталог', 'maxWidthBigThumbCatalog', '500', 'Максимальная ширина фотографии после загрузки', 'Catalog. Maximum width for calolog photos after upload', '2012-04-14 17:01:21'),
(30, 'text', 'Каталог', 'maxHeightBigThumbCatalog', '375', 'Максимальная высота фотографии после загрузки', 'Catalog. Maximum height for calolog photos after upload', '2012-04-14 17:01:21'),
(31, 'text', 'Каталог', 'module_catalog_itemsPerPage', '6', 'Количество записей на одной странице в разделе "Каталоге товаров"', 'Catalog. Number of elements per page in the section "Catalog"', '2012-04-13 17:01:21'),
(32, 'bool', 'Почта', 'mailSMTP', '0', 'Использовать отправку почты через SMTP сервер', 'Use SMTP server to send mail', '2012-04-15 17:01:21'),
(33, 'text', 'Почта', 'mailHost', 'localhost', 'Адрес SMTP сервера', 'Address of SMTP server', '2012-04-15 17:01:21'),
(34, 'text', 'Почта', 'mailPort', '25', 'Порт SMTP сервера', 'Port of SMTP server', '2012-04-15 17:01:21'),
(35, 'text', 'Почта', 'mailUser', 'login', 'Имя пользователя SMTP', 'SMTP user login', '2012-04-15 17:01:21'),
(36, 'text', 'Почта', 'mailPass', 'pass', 'Пароль пользователя SMTP', 'SMTP user password', '2012-04-15 17:01:21'),
(37, 'text', 'Почта', 'adminEmailFrom', '{adminEmail}', 'E-mail администратора', 'E-mail of the administrator', '2012-04-15 17:01:21'),
(38, 'text', 'Почта', 'mailNameFrom', 'Admin', 'Отправить почту от имени', 'Send emails from the name of', '2012-04-15 17:01:21'),
(39, 'enum', 'Почта', 'mailSMTPSecure', '', 'Способ шифрования SMTP', 'Encryption method SMTP', '2016-02-03 00:00:00'),
(40, 'bool', 'Каталог', 'useTwoLevelCatalog', '1', 'Использовать двухуровневый каталог', 'Use a two-level "Catalog"', '2013-05-09 14:15:06'),
(41, 'bool', 'Галерея', 'useGalleryGategory', '1', 'Использовать категории в Галерее', 'Use the categories in the "Gallery"', '2013-05-23 14:12:11'),
(42, 'bool', 'Главные', 'useSiteSearch', '1', 'Использовать поиск на сайте', 'Use the search form on the site', '2014-03-10 00:00:00'),
(43, 'bool', 'Главные',	'useShowInfoUseCookie',	'1', 'Отображать предупреждение об использовании Cookie на сайте', 'Display cookies warning message', '2016-05-21 08:00:04');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}gallery`
--

DROP TABLE IF EXISTS `{dbPrefix}gallery`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `description_ru` text NOT NULL,
  `description_en` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sorter` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `{dbPrefix}gallery`
--

INSERT INTO `{dbPrefix}gallery` (`id`, `id_category`, `img`, `description_ru`, `description_en`, `date_created`, `date_updated`, `active`, `sorter`) VALUES
(17, 4, '3e385679b1b585cc7fed67e3ef6a6f22.jpg', 'Toyota Camry', 'Toyota Camry', '2014-03-04 17:30:21', '2016-02-03 10:45:44', 1, 1),
(18, 4, 'bd889032e1c32c962a439fb2ecfaba8a.jpg', 'Toyota Corolla', 'Toyota Corolla', '2014-03-04 17:31:10', '2016-02-03 10:45:44', 1, 2),
(19, 5, 'fdb0a4d525b3ffff9e0f7363d4d2fcb0.png', 'Mitsubishi Outlander', 'Mitsubishi Outlander', '2014-03-04 17:31:31', '2016-02-03 10:45:44', 1, 3),
(20, 5, '6d609240971982bde2f3a8dcc640061d.jpg', 'Mitsubishi Lancer', 'Mitsubishi Lancer', '2014-03-04 17:31:44', '2016-02-03 10:45:44', 1, 4),
(21, 6, '9d37c30732bdb182ab8ed84391e1f596.png', 'Mazda 6', 'Mazda 6', '2014-03-04 17:31:58', '2016-02-03 10:45:44', 1, 5),
(22, 6, 'a0f15122c772bef27a02c6704948eebe.jpg', 'Mazda 3', 'Mazda 3', '2014-03-04 17:32:17', '2016-02-03 10:45:44', 1, 6),
(23, 7, 'e1feaf018d0b05414de83ce6fa39f00c.jpg', 'Chevrolet Aveo', 'Chevrolet Aveo', '2014-03-04 17:32:35', '2016-02-03 10:45:44', 1, 7),
(24, 8, 'ed7362145db28f8501be5bd3d7c4ee90.png', 'Audi A4', 'Audi A4', '2014-03-04 17:32:47', '2016-02-03 10:45:44', 1, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}gallery_category`
--

DROP TABLE IF EXISTS `{dbPrefix}gallery_category`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}gallery_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_ru` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sorter` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `{dbPrefix}gallery_category`
--

INSERT INTO `{dbPrefix}gallery_category` (`id`, `title_ru`, `title_en`, `date_updated`, `active`, `sorter`) VALUES
(4, 'Toyota', 'Toyota', '2016-02-03 10:59:06', 1, 1),
(5, 'Mitsubishi', 'Mitsubishi', '2016-02-03 10:59:06', 1, 2),
(6, 'Mazda', 'Mazda', '2016-02-03 10:59:06', 1, 3),
(7, 'Chevrolet', 'Chevrolet', '2016-02-03 10:59:06', 1, 4),
(8, 'Audi', 'Audi', '2016-02-03 10:59:06', 1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}info`
--

DROP TABLE IF EXISTS `{dbPrefix}info`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL,
  `description_ru` text NOT NULL,
  `description_en` text NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `{dbPrefix}info`
--

INSERT INTO `{dbPrefix}info` (`id`, `type`, `description_ru`, `description_en`, `active`, `date_updated`) VALUES
(1, 1, '<span style="color: rgb(192, 80, 77);">Внимание, акция!</span> - здесь вы можете размещать информацию о специальных предложениях. Редактируется через панель\r\nадминистратора в разделе "Администрирование" => "Информация".', '<span style="color: rgb(192, 80, 77);">Attention, special offer!</span> - here you can post info about your special offers. This area is edited in the admin panel in ''Administration'' => ''Information''.', 1, '2012-04-16 11:46:39'),
(2, 2, '<p>Это пример информации о нас. Данный раздел можно редактировать через панель администратора.</p>\r\n<p><strong>Open business card</strong> - это простое открытое решение для создания сайтов-визиток. Данный скрипт написан на быстром и современном\r\nфреймворке <strong>Yii</strong>, что позволяет идти в ногу со временем и использовать самые последние разработки в сфере программирования.</p>\r\n<p>Данный <strong>PHP скрипт</strong> использует <strong>MySQL</strong> и распространяется совершенно <strong>бесплатно</strong>.</p>\r\n', '<p>It''s an example of ''About us'' block. This area can be edited through the admin panel.</p>\r\n<p><strong>Open business card</strong> - is an easy and open solution that allows to build a business card site. The script is based on fast-working and up-to-date framework Yii, which allows to get in times and use the latest development in the programming sphere.</p>\r\n<p>This PHP script is MySQL-based and is distributed <strong>absolutely free of charge</strong>.</p>', 1, '2012-04-15 20:52:08'),
(3, 3, 'Запрошенная Вами страница не найдена', 'Requested page not found', 1, '2013-03-29 13:29:13'),
(4, 4, '<h1>\n	OPEN BUSINESS CARD CMS</h1>\n<p>\n	Это простое открытое решение для создания сайтов-визиток. Данный скрипт написан на быстром и современном фреймворке Yii.</p>\n<br />\n	<span style="font-size:10px;">Редактируется через панель администратора в разделе &quot;Администрирование&quot; =&gt; &quot;Слоган&quot;.</span>\n', '<h1>\n	OPEN BUSINESS CARD CMS</h1>\n<p>\n	It is an easy and open solution that allows to build a business card website. The script is written on a fast-working and up-to-date framework Yii.</p>\n<br />\n	<span style="font-size:10px;">The area is edited through the admin panel in &quot;Administration&quot; =&gt; &quot;Slogan&quot;.</span>\n', 1, '2014-03-06 20:27:40');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}infopages`
--

DROP TABLE IF EXISTS `{dbPrefix}infopages`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}infopages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `widget` varchar(20) NOT NULL DEFAULT '',
  `special` tinyint(4) NOT NULL DEFAULT '0',
  `title_ru` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `body_ru` text NOT NULL,
  `body_en` text NOT NULL,
  `seo_title_ru` varchar(255) NOT NULL,
  `seo_title_en` varchar(255) NOT NULL,
  `seo_keywords_ru` text NOT NULL,
  `seo_keywords_en` text NOT NULL,
  `seo_description_ru` text NOT NULL,
  `seo_description_en` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title_ru`),
  FULLTEXT KEY `body` (`body_ru`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `{dbPrefix}infopages`
--

INSERT INTO `{dbPrefix}infopages` (`id`, `active`, `widget`, `special`, `title_ru`, `title_en`, `date_created`, `date_updated`, `body_ru`, `body_en`, `seo_title_ru`, `seo_title_en`, `seo_keywords_ru`, `seo_keywords_en`, `seo_description_ru`, `seo_description_en`) VALUES
(1, 1, '', 1, 'Главная', 'Homepage', '2014-02-20 00:00:00', '2016-02-04 06:50:15', '<p>Open Business Card - это программное обеспечение для создания сайта-визитки. Распространяется полностью бесплатно, исходный код полностью открыт. Самую последнюю версию Вы всегда можете скачать на&nbsp;<a href="http://monoray.ru/products/51-open-business-card" target="_blank" title="Описание продукта Open Business Card">нашем сайте</a>.</p>\r\n<p>Единственным ограничением является то, что Вы не должны удалять активную ссылку на наш сайт, расположенную в самом низу страниц. Для удаления активной ссылки Вы должны&nbsp;<a href="http://monoray.ru/contact" target="_blank" title="Связь с нами">связаться с нами</a>.</p>\r\n<p><strong>Вам необходимы дополнительные функции или изменение дизайна продукта?</strong></p>\r\n<p><a href="http://monoray.ru/contact" target="_blank">Закажите разработку</a>&nbsp; у нас! Мы реализуем Ваши самые смелые идеи.</p>', '<p>Open Business Card is a software that enables to build a business card website. The script is distributed absolutely free of charge, the code is completely open. You can always <a href="http://monoray.net/products/51-open-business-card" target="_blank" title="Download the latest version">download the latest version on our site</a>.</p>\r\n<p>The only limitation is a ban to remove an active link to our corporate site in the bottom of the pages. If you want to remove the active link <a href="http://monoray.net/contact" target="_blank" title="Contact us">please contact us!</a>.</p>\r\n<p><strong>Do you need any extra features or redesigning?</strong></p>\r\n<p><a href="http://monoray.net/contact" target="_blank">Order the development from us</a>! We will implement your most extraordinary ideas!</p>\r\n', 'Open Business Card - Главная страница', 'Open Business Card - Homepage', 'Open Business Card - Meta Keywords', 'Open Business Card - Meta Keywords', 'Open Business Card - Meta Description', 'Open Business Card - Meta Description'),
(2, 1, '', 1, 'Политика конфиденциальности', 'Privacy Policy', '2016-05-21 00:00:00', '2016-05-20 21:00:00', '<p>This privacy policy has been compiled to better serve those who are concerned with how their ''Personally identifiable information'' (PII) is being used online. PII, as used in US privacy law and information security, is information that can be used on its own or with other information to identify, contact, or locate a single person, or to identify an individual in context. Please read our privacy policy carefully to get a clear understanding of how we collect, use, protect or otherwise handle your Personally Identifiable Information in accordance with our website.</p>\r\n<p><strong>What personal information do we collect from the people that visit our blog, website or app?</strong></p>\r\n<p>When ordering or registering on our site, as appropriate, you may be asked to enter your name, email address, mailing address, phone number, social security number or other details to help you with your experience.</p>\r\n<p><strong>When do we collect information?</strong></p>\r\n<p>We collect information from you when you register on our site, place an order, subscribe to a newsletter, respond to a survey, fill out a form or enter information on our site.</p>\r\n<p><strong>How do we use your information? </strong></p>\r\n<p>We may use the information we collect from you when you register, make a purchase, sign up for our newsletter, respond to a survey or marketing communication, surf the website, or use certain other site features in the following ways:</p>\r\n<ol>\r\n    <li>To personalize user''s experience and to allow us to deliver the type of content and product offerings in which you are most interested.</li>\r\n    <li>To improve our website in order to better serve you.</li>\r\n	<li>To allow us to better service you in responding to your customer service requests.</li>\r\n	<li>To administer a contest, promotion, survey or other site feature.</li>\r\n	<li>Identify persons who may be viliating the law, the YOUR COMPANY SITE/NETWORK legal notice and Web site User Agreement, the rights of third parties, or otherwise misusing the YOUR COMPANY SITE/NETWORK or its related properties;</li>\r\n	<li>To send periodic emails regarding your order or other products and services.</li>\r\n</ol>\r\n<p><strong>How do we protect visitor information?</strong></p>\r\n<p>We do not use vulnerability scanning and/or scanning to PCI standards.</p>\r\n<p>We do not use Malware Scanning.</p>\r\n<p>We do not use an SSL certificate.</p>\r\n<p><strong>Do we use ''cookies''?</strong></p>\r\n<p>Yes. Cookies are small files that a site or its service provider transfers to your computer''s hard drive through your Web browser (if you allow) that enables the site''s or service provider''s systems to recognize your browser and capture and remember certain information. For instance, we use cookies to help us remember and process the items in your shopping cart. They are also used to help us understand your preferences based on previous or current site activity, which enables us to provide you with improved services. We also use cookies to help us compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.</p>\r\n<p><strong>We use cookies to:</strong></p>\r\n<ol>\r\n    <li>Understand and save user''s preferences for future visits.</li>\r\n    <li>Keep track of advertisements.</li>\r\n	<li>Compile aggregate data about site traffic and site interactions in order to offer better site experiences and tools in the future. We may also use trusted third-party services that track this information on our behalf.</li>\r\n</ol>\r\n<p>You can choose to have your computer warn you each time a cookie is being sent, or you can choose to turn off all cookies. You do this through your browser (like Internet Explorer) settings. Each browser is a little different, so look at your browser''s Help menu to learn the correct way to modify your cookies.</p>\r\n<p><strong>If users disable cookies in their browser:</strong></p>\r\n<p>If you disable cookies off, some features will be disabled It will turn off some of the features that make your site experience more efficient and some of our services will not function properly.</p>\r\n<p><strong>Third-Party Disclosure</strong></p>\r\n<p>We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information unless we provide users with advance notice. This does not include website hosting partners and other parties who assist us in operating our website, conducting our business, or servicing our users, so long as those parties agree to keep this information confidential. We may also release information when it''s release is appropriate to comply with the law, enforce our site policies, or protect ours or others'' rights, property, or safety. </p>\r\n<p>However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses. </p>\r\n<p><strong>Third-party links</strong></p>\r\n<p>We do not include or offer third-party products or services on our website.</p>\r\n<p><strong>Google</strong></p>\r\n<p>Google''s advertising requirements can be summed up by Google''s Advertising Principles. They are put in place to provide a positive experience for users. https://support.google.com/adwordspolicy/answer/1316548?hl=en </p>\r\n<p>We use Google AdSense Advertising on our website.</p>\r\n<p>Google, as a third-party vendor, uses cookies to serve ads on our site. Google''s use of the DART cookie enables it to serve ads to our users based on previous visits to our site and other sites on the Internet. Users may opt-out of the use of the DART cookie by visiting the Google Ad and Content Network privacy policy.</p>\r\n<p><strong>We have implemented the following:</strong></p>\r\n<ol>\r\n    <li>Remarketing with Google AdSense</li>\r\n    <li>Google Display Network Impression Reporting</li>\r\n	<li>Demographics and Interests Reporting</li>\r\n	<li>DoubleClick Platform Integration</li>\r\n</ol>\r\n<p>We along with third-party vendors, such as Google use first-party cookies (such as the Google Analytics cookies) and third-party cookies (such as the DoubleClick cookie) or other third-party identifiers together to compile data regarding user interactions with ad impressions and other ad service functions as they relate to our website. </p>\r\n<p>Opting out: Users can set preferences for how Google advertises to you using the Google Ad Settings page. Alternatively, you can opt out by visiting the Network Advertising initiative opt out page or permanently using the Google Analytics Opt Out Browser add on.</p>\r\n<p><strong>California Online Privacy Protection Act</strong></p>\r\n<p>CalOPPA is the first state law in the nation to require commercial websites and online services to post a privacy policy. The law''s reach stretches well beyond California to require a person or company in the United States (and conceivably the world) that operates websites collecting personally identifiable information from California consumers to post a conspicuous privacy policy on its website stating exactly the information being collected and those individuals with whom it is being shared, and to comply with this policy. - See more at: http://consumercal.org/california-online-privacy-protection-act-caloppa/#sthash.0FdRbT51.dpuf</p>\r\n<p><strong>According to CalOPPA we agree to the following:</strong></p>\r\n<p>Users can visit our site anonymously. Once this privacy policy is created, we will add a link to it on our home page or as a minimum on the first significant page after entering our website. Our Privacy Policy link includes the word ''Privacy'' and can be easily be found on the page specified above.</p>\r\n<p><strong>How does our site handle do not track signals?</strong></p>\r\n<p>We honor do not track signals and do not track, plant cookies, or use advertising when a Do Not Track (DNT) browser mechanism is in place. </p>\r\n<p><strong>Does our site allow third-party behavioral tracking?</strong></p>\r\n<p>It''s also important to note that we allow third-party behavioral tracking</p>\r\n<p><strong>COPPA (Children Online Privacy Protection Act)</strong></p>\r\n<p>When it comes to the collection of personal information from children under 13, the Children''s Online Privacy Protection Act (COPPA) puts parents in control. The Federal Trade Commission, the nation''s consumer protection agency, enforces the COPPA Rule, which spells out what operators of websites and online services must do to protect children''s privacy and safety online. We do not specifically market to children under 13.</p>\r\n<p><strong>Fair Information Practices</strong></p>\r\n<p>The Fair Information Practices Principles form the backbone of privacy law in the United States and the concepts they include have played a significant role in the development of data protection laws around the globe. Understanding the Fair Information Practice Principles and how they should be implemented is critical to comply with the various privacy laws that protect personal information.</p>\r\n<p><strong>CAN SPAM Act</strong></p>\r\n<p>The CAN-SPAM Act is a law that sets the rules for commercial email, establishes requirements for commercial messages, gives recipients the right to have emails stopped from being sent to them, and spells out tough penalties for violations.</p>\r\n<p><strong>Contacting Us</strong></p>\r\n<p>If there are any questions regarding this privacy policy you may contact us using the information below.</p>\r\n<br /><br />\r\n<p>YOUSITEDOMAIN</p>\r\n<p>Last Edited on 2016-02-05</p>\r\n', '<p>This privacy policy has been compiled to better serve those who are concerned with how their ''Personally identifiable information'' (PII) is being used online. PII, as used in US privacy law and information security, is information that can be used on its own or with other information to identify, contact, or locate a single person, or to identify an individual in context. Please read our privacy policy carefully to get a clear understanding of how we collect, use, protect or otherwise handle your Personally Identifiable Information in accordance with our website.</p>\r\n<p><strong>What personal information do we collect from the people that visit our blog, website or app?</strong></p>\r\n<p>When ordering or registering on our site, as appropriate, you may be asked to enter your name, email address, mailing address, phone number, social security number or other details to help you with your experience.</p>\r\n<p><strong>When do we collect information?</strong></p>\r\n<p>We collect information from you when you register on our site, place an order, subscribe to a newsletter, respond to a survey, fill out a form or enter information on our site.</p>\r\n<p><strong>How do we use your information? </strong></p>\r\n<p>We may use the information we collect from you when you register, make a purchase, sign up for our newsletter, respond to a survey or marketing communication, surf the website, or use certain other site features in the following ways:</p>\r\n<ol>\r\n    <li>To personalize user''s experience and to allow us to deliver the type of content and product offerings in which you are most interested.</li>\r\n    <li>To improve our website in order to better serve you.</li>\r\n	<li>To allow us to better service you in responding to your customer service requests.</li>\r\n	<li>To administer a contest, promotion, survey or other site feature.</li>\r\n	<li>Identify persons who may be viliating the law, the YOUR COMPANY SITE/NETWORK legal notice and Web site User Agreement, the rights of third parties, or otherwise misusing the YOUR COMPANY SITE/NETWORK or its related properties;</li>\r\n	<li>To send periodic emails regarding your order or other products and services.</li>\r\n</ol>\r\n<p><strong>How do we protect visitor information?</strong></p>\r\n<p>We do not use vulnerability scanning and/or scanning to PCI standards.</p>\r\n<p>We do not use Malware Scanning.</p>\r\n<p>We do not use an SSL certificate.</p>\r\n<p><strong>Do we use ''cookies''?</strong></p>\r\n<p>Yes. Cookies are small files that a site or its service provider transfers to your computer''s hard drive through your Web browser (if you allow) that enables the site''s or service provider''s systems to recognize your browser and capture and remember certain information. For instance, we use cookies to help us remember and process the items in your shopping cart. They are also used to help us understand your preferences based on previous or current site activity, which enables us to provide you with improved services. We also use cookies to help us compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.</p>\r\n<p><strong>We use cookies to:</strong></p>\r\n<ol>\r\n    <li>Understand and save user''s preferences for future visits.</li>\r\n    <li>Keep track of advertisements.</li>\r\n	<li>Compile aggregate data about site traffic and site interactions in order to offer better site experiences and tools in the future. We may also use trusted third-party services that track this information on our behalf.</li>\r\n</ol>\r\n<p>You can choose to have your computer warn you each time a cookie is being sent, or you can choose to turn off all cookies. You do this through your browser (like Internet Explorer) settings. Each browser is a little different, so look at your browser''s Help menu to learn the correct way to modify your cookies.</p>\r\n<p><strong>If users disable cookies in their browser:</strong></p>\r\n<p>If you disable cookies off, some features will be disabled It will turn off some of the features that make your site experience more efficient and some of our services will not function properly.</p>\r\n<p><strong>Third-Party Disclosure</strong></p>\r\n<p>We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information unless we provide users with advance notice. This does not include website hosting partners and other parties who assist us in operating our website, conducting our business, or servicing our users, so long as those parties agree to keep this information confidential. We may also release information when it''s release is appropriate to comply with the law, enforce our site policies, or protect ours or others'' rights, property, or safety. </p>\r\n<p>However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses. </p>\r\n<p><strong>Third-party links</strong></p>\r\n<p>We do not include or offer third-party products or services on our website.</p>\r\n<p><strong>Google</strong></p>\r\n<p>Google''s advertising requirements can be summed up by Google''s Advertising Principles. They are put in place to provide a positive experience for users. https://support.google.com/adwordspolicy/answer/1316548?hl=en </p>\r\n<p>We use Google AdSense Advertising on our website.</p>\r\n<p>Google, as a third-party vendor, uses cookies to serve ads on our site. Google''s use of the DART cookie enables it to serve ads to our users based on previous visits to our site and other sites on the Internet. Users may opt-out of the use of the DART cookie by visiting the Google Ad and Content Network privacy policy.</p>\r\n<p><strong>We have implemented the following:</strong></p>\r\n<ol>\r\n    <li>Remarketing with Google AdSense</li>\r\n    <li>Google Display Network Impression Reporting</li>\r\n	<li>Demographics and Interests Reporting</li>\r\n	<li>DoubleClick Platform Integration</li>\r\n</ol>\r\n<p>We along with third-party vendors, such as Google use first-party cookies (such as the Google Analytics cookies) and third-party cookies (such as the DoubleClick cookie) or other third-party identifiers together to compile data regarding user interactions with ad impressions and other ad service functions as they relate to our website. </p>\r\n<p>Opting out: Users can set preferences for how Google advertises to you using the Google Ad Settings page. Alternatively, you can opt out by visiting the Network Advertising initiative opt out page or permanently using the Google Analytics Opt Out Browser add on.</p>\r\n<p><strong>California Online Privacy Protection Act</strong></p>\r\n<p>CalOPPA is the first state law in the nation to require commercial websites and online services to post a privacy policy. The law''s reach stretches well beyond California to require a person or company in the United States (and conceivably the world) that operates websites collecting personally identifiable information from California consumers to post a conspicuous privacy policy on its website stating exactly the information being collected and those individuals with whom it is being shared, and to comply with this policy. - See more at: http://consumercal.org/california-online-privacy-protection-act-caloppa/#sthash.0FdRbT51.dpuf</p>\r\n<p><strong>According to CalOPPA we agree to the following:</strong></p>\r\n<p>Users can visit our site anonymously. Once this privacy policy is created, we will add a link to it on our home page or as a minimum on the first significant page after entering our website. Our Privacy Policy link includes the word ''Privacy'' and can be easily be found on the page specified above.</p>\r\n<p><strong>How does our site handle do not track signals?</strong></p>\r\n<p>We honor do not track signals and do not track, plant cookies, or use advertising when a Do Not Track (DNT) browser mechanism is in place. </p>\r\n<p><strong>Does our site allow third-party behavioral tracking?</strong></p>\r\n<p>It''s also important to note that we allow third-party behavioral tracking</p>\r\n<p><strong>COPPA (Children Online Privacy Protection Act)</strong></p>\r\n<p>When it comes to the collection of personal information from children under 13, the Children''s Online Privacy Protection Act (COPPA) puts parents in control. The Federal Trade Commission, the nation''s consumer protection agency, enforces the COPPA Rule, which spells out what operators of websites and online services must do to protect children''s privacy and safety online. We do not specifically market to children under 13.</p>\r\n<p><strong>Fair Information Practices</strong></p>\r\n<p>The Fair Information Practices Principles form the backbone of privacy law in the United States and the concepts they include have played a significant role in the development of data protection laws around the globe. Understanding the Fair Information Practice Principles and how they should be implemented is critical to comply with the various privacy laws that protect personal information.</p>\r\n<p><strong>CAN SPAM Act</strong></p>\r\n<p>The CAN-SPAM Act is a law that sets the rules for commercial email, establishes requirements for commercial messages, gives recipients the right to have emails stopped from being sent to them, and spells out tough penalties for violations.</p>\r\n<p><strong>Contacting Us</strong></p>\r\n<p>If there are any questions regarding this privacy policy you may contact us using the information below.</p>\r\n<br /><br />\r\n<p>YOUSITEDOMAIN</p>\r\n<p>Last Edited on 2016-02-05</p>\r\n', 'Политика конфиденциальности', 'Privacy Policy', 'Политика конфиденциальности', 'Privacy Policy', 'Политика конфиденциальности', 'Privacy Policy');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}lang`
--

DROP TABLE IF EXISTS `{dbPrefix}lang`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `name_iso` varchar(20) NOT NULL,
  `name_rfc3066` varchar(10) NOT NULL,
  `name_ru` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `sorter` int(11) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name_en` varchar(100) NOT NULL,
  `admin_mail` tinyint(4) NOT NULL DEFAULT '0',
  `flag_img` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `{dbPrefix}lang`
--

INSERT INTO `{dbPrefix}lang` (`id`, `main`, `name_iso`, `name_rfc3066`, `name_ru`, `active`, `sorter`, `date_updated`, `name_en`, `admin_mail`, `flag_img`) VALUES
(1, 0, 'ru', 'ru-RU', 'Русский', 1, 2, '2016-02-02 03:12:52', 'Russian', 0, 'ru.png'),
(2, 1, 'en', 'en-US', 'Английский', 1, 1, '2016-02-02 00:53:22', 'English', 1, 'us.png');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}menu`
--

DROP TABLE IF EXISTS `{dbPrefix}menu`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(10) unsigned NOT NULL DEFAULT '0',
  `number` int(11) NOT NULL DEFAULT '0',
  `pageId` int(11) NOT NULL DEFAULT '0',
  `title_ru` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `href_ru` varchar(255) NOT NULL,
  `href_en` varchar(255) NOT NULL,
  `is_blank` tinyint(4) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date_updated` datetime NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `special` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parentId` (`parentId`),
  KEY `pageId` (`pageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `{dbPrefix}menu`
--

INSERT INTO `{dbPrefix}menu` (`id`, `parentId`, `number`, `pageId`, `title_ru`, `title_en`, `href_ru`, `href_en`, `is_blank`, `active`, `date_updated`, `type`, `special`) VALUES
(1, 0, 1, 1, 'Главная', 'Home', '/site/index', '/site/index', 0, 1, '2013-02-18 09:55:32', 2, 1),
(2, 0, 2, 0, 'Новости', 'News', '/news/main/index', '/news/main/index', 0, 1, '2013-01-26 22:10:17', 1, 1),
(3, 0, 3, 0, 'Статьи', 'Articles', '/articles/main/index', '/articles/main/index', 0, 1, '2013-01-27 10:09:31', 1, 1),
(4, 0, 4, 0, 'Галерея', 'Gallery', '/gallery/main/index', '/gallery/main/index', 0, 1, '2016-02-04 12:49:55', 1, 1),
(5, 0, 5, 0, 'Каталог', 'Catalog', '/catalog/main/index', '/catalog/main/index', 0, 1, '2014-02-20 21:48:06', 1, 1),
(6, 0, 6, 0, 'Прайс', 'Price', '/price/main/index', '/price/main/index', 0, 1, '2014-02-20 21:48:06', 1, 1),
(7, 0, 9, 0, 'Контакты', 'Contact us', '/contactform/main/index', '/contactform/main/index', 0, 1, '2016-02-04 12:29:08', 1, 1),
(8, 0, 7, 0, 'Отзывы', 'Reviews', '/reviews/main/index', '/reviews/main/index', 0, 1, '2014-03-06 14:27:21', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}news`
--

DROP TABLE IF EXISTS `{dbPrefix}news`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_ru` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `body_ru` text NOT NULL,
  `body_en` text NOT NULL,
  `short_body_ru` text NOT NULL,
  `short_body_en` text NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `seo_title_ru` varchar(255) NOT NULL,
  `seo_title_en` varchar(255) NOT NULL,
  `seo_keywords_ru` text NOT NULL,
  `seo_keywords_en` text NOT NULL,
  `seo_description_ru` text NOT NULL,
  `seo_description_en` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`),
  FULLTEXT KEY `title` (`title_ru`),
  FULLTEXT KEY `body` (`body_ru`),
  FULLTEXT KEY `short_body` (`short_body_ru`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `{dbPrefix}news`
--

INSERT INTO `{dbPrefix}news` (`id`, `title_ru`, `title_en`, `body_ru`, `body_en`, `short_body_ru`, `short_body_en`, `active`, `date_created`, `date_updated`, `seo_title_ru`, `seo_title_en`, `seo_keywords_ru`, `seo_keywords_en`, `seo_description_ru`, `seo_description_en`) VALUES
(1, 'С конвейера сошла последняя Lada-2107', 'With the conveyor descended last Lada-2107', '<p><strong>Вчера с конвейера &laquo;ИжАвто&raquo; сошла последняя Lada-2107 &ndash; самое дешевое авто на отечественном авторынке. </strong></p>\n\n<p>Напомним, что на днях ОАО &laquo;АвтоВАЗ&raquo; принял решение <em><strong><a href="http://www.motorpage.ru/news/68677/" target="_blank">отказаться от производства Lada-2107</a></strong></em>, так как в последнее время эта модель не пользовалась спросом.</p>\n\n<p>Также напомним, что производство полного цикла модели Lada-2107 было налажено в Ижевске в 2011 году, и теперь на конвейере осталась модель Lada-2104. Однако на днях стало известно, что к концу 2012 года будет свернуто и ее производство. &laquo;В настоящее время Ижевский автозавод модернизируется и обновляет модельный ряд: на смену &laquo;классике&raquo; уже совсем скоро придет новый автомобиль Lada Granta, начало его производства запланировано на август 2012 года&raquo;, &ndash; цитирует РИА Новости пресс-службу предприятия.</p>\n\n<p>По данным АЕБ, лидерами продаж тольяттинского завода по итогам I квартала текущего года стали Lada Kalina, Priora и Granta, тогда как &laquo;классика&raquo; уже перестала пользоваться популярностью у населения.</p>\n\n<p>Источник: <a href="http://www.motorpage.ru/news/68752/" rel="nofollow" target="_blank">http://www.motorpage.ru/news/68752/</a></p>\n\n<p>По материалам: <a href="http://auto.vesti.ru/" rel="nofollow" target="_blank">Авто.Вести.ру</a>, <a href="http://www.autostat.ru/" rel="nofollow" target="_blank">Автостат</a>&nbsp;</p>\n', '<p><strong>Yesterday from the pipeline &laquo;the Plant&quot; went down last Lada-2107 &ndash; the cheapest car in the domestic car market. </strong></p>\n\n<p>Recall that the JSC &laquo;AVTOVAZ&raquo; decided <em><strong><a href="http://www.motorpage.ru/news/68677/" target="_blank">to abandon the production of Lada-2107</a></strong></em>, as in recent times this model is not in demand.</p>\n\n<p>Also recall that the full-cycle production of Lada-2107 was established in Izhevsk in 2011, and now on the line were the model Lada-2104. However, recently it became known that by the end of 2012 will be collapsed and its production. &laquo;At the present time Izhevsk plant is modernized and updates the model range, replacing the &quot;classics&quot; very soon will come a new car Lada Granta, the production is scheduled for August 2012&raquo;, &ndash; RIA Novosti quoted the press service of the company.</p>\n\n<p>According to the AEB, the sales of the Tolyatti plant in the I quarter of current year became Lada Kalina, Priora and Granta, while the &ldquo;classic&rdquo; has ceased to enjoy popularity among the population.</p>\n\n<p>Source: <a href="http://www.motorpage.ru/news/68752/" rel="nofollow" target="_blank">http://www.motorpage.ru/news/68752/</a></p>\n\n<p>source: <a href="http://auto.vesti.ru/" rel="nofollow" target="_blank">Auto.News.ru</a>, <a href="http://www.autostat.ru/" rel="nofollow" target="_blank">AUTOSTAT</a>&nbsp;</p>', '', '', 1, '2016-02-03 13:18:29', '2016-02-04 10:12:29', 'Open Business Card - С конвейера сошла последняя Lada-2107', 'Open Business Card - the assembly line went last Lada-2107', 'Lada-2107', '', 'С конвейера сошла последняя Lada-2107', ''),
(2, 'Автопродажи в Евросоюзе откатились на 14 лет назад', 'Car sales in the EU fell back to 14 years ago', '<p><strong>В марте текущего года продажи новых автомобилей в Евросоюзе снова демонстрировали падение &ndash; уже 6-й месяц подряд.&nbsp;</strong></p>\n\n<p>По сравнению с мартом прошлого года уровень автопродаж упал на 7%, так что количество автомобилей, проданных в марте 2012-го, достигло своего минимума, начиная с 1998 года.</p>\n\n<p>В сообщении Ассоциации европейских автопроизводителей сказано, что в марте в ЕС было продано всего 1,45 млн новых машин &ndash; это минимальный показатель для этого месяца с 1998 года. С начала 2012 года уровень продаж также упал на 7,7% по сравнению с I кварталом 2011 года.</p>\n\n<p>По мнению экспертов, продажи снижаются из-за опасений европейцев, которые боятся кризиса. Максимальный спад был отмечен в марте в Португалии &ndash; на 49,2%, в Греции &ndash; на 42,6%, на Кипре &ndash; на 35%, в Италии &ndash; на 26,7%, во Франции &ndash; на 23,2%, а в Испании &ndash; всего на 4,5%. При этом в некоторых странах Евросоюза был отмечен рост продаж автомобилей. В Финляндии в марте было продано на 82% машин больше, чем в марте 2011 года, в Эстонии &ndash; на 28,5%, в Австрии &ndash; на 5,8%, в Германии &ndash; на 3,4%.</p>\n\n<p>Во Франции и Италии, чьи потребители часто выбирают национальные бренды, снижение количества продаж стало причиной падения продаж у местных компаний. В частности, Peugeot-Citroen в марте потеряли 19,4%, Renault Group &ndash;20,6%, Fiat &ndash; 26,1%. Продажи немецких автоконцернов показали небольшой рост. Так, Volkswagen Group отмечает рост на 1,3%, Daimler &ndash; на 4,3%, а баварский концерн BMW &ndash; на 3,1%.</p>\n\n<p>Источник: <a href="http://www.motorpage.ru/news/68754/" rel="nofollow" target="_blank">http://www.motorpage.ru/news/68754/</a></p>\n\n<p>По материалам: <a href="http://www.kommersant.ru/" rel="nofollow" target="_blank">Коммерсантъ</a>&nbsp;</p>\n', '<p><strong>In March of this year, sales of new cars in the European Union again demonstrated the fall &ndash; already the 6th month in a row.&nbsp;</strong></p>\n\n<p>compared with March of last year the level of sales fell by 7%, so the number of cars sold in March 2012, reached its minimum since 1998.</p>\n\n<p>In the message of Association of European automakers said that in March the EC has sold only 1.45 million new cars &ndash; this is the lowest figure for that month since 1998. Since the beginning of 2012 the level of sales also fell by 7.7% compared to the first quarter of 2011.</p>\n\n<p>According to experts, sales are falling because of fears of Europeans who are afraid of the crisis. The maximum decrease was recorded in March in Portugal-49.2%, Greece-by 42.6%, in Cyprus &ndash; 35% in Italy &ndash; 26.7%, France &ndash; 23.2%, and in Spain &ndash; only 4.5%. While some EU countries reported increases in car sales. In Finland in March, it sold 82 percent more cars than in March 2011, in Estonia-28.5%, Austria-5.8%, Germany-by 3.4%.</p>\n\n<p>In France and Italy, whose consumers often choose national brands, reduced the number of sales caused the drop in sales from local companies. In particular, Peugeot-Citroen in March, lost 19.4 percent, Renault Group &ndash;20.6 per cent, Fiat &ndash; 26.1 per cent. Sales of German automakers showed a slight increase. So, the Volkswagen Group notes an increase of 1.3%, Daimler &ndash; by 4.3%, and Bavarian BMW &ndash; is up 3.1%.</p>\n\n<p>Source: <a href="http://www.motorpage.ru/news/68754/" rel="nofollow" target="_blank">http://www.motorpage.ru/news/68754/</a></p>\n\n<p>source: <a href="http://www.kommersant.ru/" rel="nofollow" target="_blank">Kommersant</a>&nbsp;</p>', '', '', 1, '2016-02-03 13:18:29', '2016-02-04 10:12:42', 'Open Business Card - Автопродажи в Евросоюзе откатились на 14 лет назад', 'Open Business Card - car sales in the EU fell back to 14 years ago', 'Автопродажи Еврозоюза', 'Car sales Evrozoyuza', 'Автопродажи в Евросоюзе откатились на 14 лет назад', 'Car sales in the EU fell back to 14 years ago'),
(3, 'Citroen DS5 выходит на российский авторынок', 'Citroen DS5 goes to the Russian car market', '<p><strong>Французский концерн Citroen выводит на российский рынок следующую модель премиальной линии DS &ndash; DS5.</strong></p>\n\n<p>Россиянам будет доступен Citroen DS5 с одним из двух двигателей на выбор: бензиновым THP 150, разработанным совместно с баварским концерном BMW, и дизельным THP 160 совместной разработки с американской компанией Ford. Оба мотора будут агрегатированы с шестиcтупенчатым &laquo;автоматом&raquo;.</p>\n\n<p>Напомним, что Citroen DS5 &ndash; старший в линейке автомобилей, которую открывает DS3. А уже 23 апреля текущего года на Международном автосалоне в Пекине французы устроят мировую премьеру концепта Numero 9 &ndash; флагманской модели линейки DS.</p>\n\n<p>Стартовая цена Citroen DS5 в России составляет 1,119 млн рублей за бензиновую версию. Топовая модификация с дизелем будет стоить 1,479 млн рублей.</p>\n\n<p>Отметим, что пятиместный Citroen DS5 отличается &laquo;аэродинамической&raquo; архитектурой, компактностью и вместительным багажным отделением &ndash; 465 л</p>\n\n<p>&nbsp;</p>\n', '<p><strong>French company Citroen introduces on the Russian market following the model in the premium DS line-the DS5.</strong></p>\n\n<p>the Russians Citroen DS5 will be available with one of two engines on a choice: petrol THP 150, developed jointly with Bavarian concern BMW, and diesel THP 160 joint development with the American company Ford. Both engines will be aggregated with six-step &quot;machine&quot;.</p>\n\n<p>Recall that the Citroen DS5 &ndash; senior in the line of cars, which opens the DS3. But already on 23 April this year at the International motor show in Beijing the French will be satisfied with the global premiere of the concept Numero 9 &ndash; a flagship model of the DS line.</p>\n\n<p>the Starting price of the Citroen DS5 in Russia amounted to 1,119 million rubles for the petrol version. Top specification with diesel will cost 1,479 million.</p>\n\n<p>Note that the five-seat Citroen DS5 is different &quot;aerodynamic&quot; architecture, compact dimensions and a roomy Luggage compartment &ndash; 465 l</p>\n\n<p>&nbsp;</p>', '', '', 1, '2016-02-03 13:18:29', '2016-02-04 10:13:32', 'Open Business Card - Citroen DS5 выходит на российский авторынок', 'Open Business Card - Citroen DS5 goes to the Russian car market', 'Citroen DS5', 'Citroen DS5', 'Citroen DS5 выходит на российский авторынок', 'Citroen DS5 goes to the Russian car market');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}price`
--

DROP TABLE IF EXISTS `{dbPrefix}price`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `name_ru` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `cost_ru` varchar(255) NOT NULL,
  `cost_en` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `is_bold` tinyint(4) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sorter` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`),
  KEY `cat_id` (`cat_id`),
  FULLTEXT KEY `name` (`name_ru`),
  FULLTEXT KEY `cost` (`cost_ru`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `{dbPrefix}price`
--

INSERT INTO `{dbPrefix}price` (`id`, `cat_id`, `name_ru`, `name_en`, `cost_ru`, `cost_en`, `time`, `is_bold`, `active`, `sorter`, `date_created`, `date_updated`) VALUES
(1, 1, 'Audi A4', 'Audi A4', 'от 1 200 000 рублей', 'from $ 40 000', '', 1, 1, 1, '2013-05-24 14:01:28', '2016-02-03 12:06:58'),
(2, 2, 'Chevrolet Aveo', 'Chevrolet Aveo', 'от 450 000 рублей', 'from $ 15 000', '', 0, 1, 2, '2013-05-24 14:01:45', '2016-02-03 12:07:11'),
(3, 3, 'Mazda 3', 'Mazda 3', 'от 650 000 рублей', 'from $ 21 500', '', 0, 1, 3, '2013-05-24 14:01:59', '2016-02-03 12:07:32'),
(4, 3, 'Mazda 6', 'Mazda 6', 'от 800 000 рублей', 'from $ 26 500', '', 0, 1, 4, '2013-05-24 14:02:10', '2016-02-03 12:08:19'),
(5, 4, 'Mitsubishi Lancer', 'Mitsubishi Lancer', 'от 680 000 рублей', 'from $ 22 500', '', 0, 1, 5, '2013-05-24 14:02:22', '2016-02-03 12:08:08'),
(6, 4, 'Mitsubishi Outlander', 'Mitsubishi Outlander', 'от 700 000 рублей', 'from $ 23 000', '', 0, 1, 6, '2013-05-24 14:02:35', '2016-02-03 12:07:59'),
(7, 5, 'Toyota Camry', 'Toyota Camry', 'от 1 000 000 рублей', 'from $ 33 000', '', 1, 1, 7, '2013-05-24 14:02:48', '2016-02-03 12:07:44'),
(8, 5, 'Toyota Corolla', 'Toyota Corolla', 'от 660 000 рублей', 'from $ 21 500', '', 0, 1, 8, '2013-05-24 14:03:00', '2016-02-03 12:07:33');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}price_category`
--

DROP TABLE IF EXISTS `{dbPrefix}price_category`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}price_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_ru` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `sorter` int(11) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `{dbPrefix}price_category`
--

INSERT INTO `{dbPrefix}price_category` (`id`, `name_ru`, `name_en`, `active`, `sorter`, `date_updated`) VALUES
(1, 'Audi', 'Audi', 1, 1, '2016-02-03 11:58:26'),
(2, 'Chevrolet', 'Chevrolet', 1, 2, '2016-02-03 11:58:26'),
(3, 'Mazda', 'Mazda', 1, 3, '2016-02-03 11:58:26'),
(4, 'Mitsubishi', 'Mitsubishi', 1, 4, '2016-02-03 11:58:26'),
(5, 'Toyota', 'Toyota', 1, 5, '2016-02-03 11:58:26');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}reviews`
--

DROP TABLE IF EXISTS `{dbPrefix}reviews`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `sorter` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_updated` (`date_updated`),
  FULLTEXT KEY `body` (`body`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `{dbPrefix}reviews`
--

INSERT INTO `{dbPrefix}reviews` (`id`, `name`, `body`, `date_created`, `date_updated`, `active`, `sorter`) VALUES
(10, 'Demo', 'Данный PHP скрипт использует MySQL и распространяется совершенно бесплатно.', '2016-02-01 14:18:42', '2016-02-01 07:21:34', 1, 1),
(11, 'test', 'Скачать скрипт можно со страницы продукта - http://monoray.ru/products/51-open-business-card', '2016-02-02 14:40:48', '2016-02-02 07:33:33', 1, 2),
(12, 'Demo', 'You can always download the latest version of the script from this website - http://monoray.net/products/51-open-business-card', '2016-02-04 12:57:50', '2016-02-04 10:02:37', 1, 3),
(13, 'Test', 'This PHP script is MySQL-based and is distributed absolutely free of charge.', '2016-02-04 12:59:41', '2016-02-04 10:02:39', 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}service`
--

DROP TABLE IF EXISTS `{dbPrefix}service`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` text NOT NULL,
  `is_offline` tinyint(1) NOT NULL,
  `allow_ip` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `{dbPrefix}service`
--

INSERT INTO `{dbPrefix}service` (`id`, `page`, `is_offline`, `allow_ip`) VALUES
(1, '<p>Closed for maintenance</p>', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}translate_message`
--

DROP TABLE IF EXISTS `{dbPrefix}translate_message`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}translate_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL,
  `translation_en` text NOT NULL,
  `translation_ru` text NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=274 ;

--
-- Дамп данных таблицы `{dbPrefix}translate_message`
--

INSERT INTO `{dbPrefix}translate_message` (`id`, `category`, `status`, `message`, `translation_en`, `translation_ru`, `date_updated`) VALUES
(1, 'module_seo', 0, 'Название сайта', '{siteName}', '{siteName}', '2016-02-03 10:34:33'),
(2, 'module_seo', 0, 'Ключевые слова сайта', '{siteKeywords}', '{siteKeywords}', '2016-02-03 10:35:09'),
(3, 'module_seo', 0, 'Описание сайта', '{siteDescription}', '{siteDescription}', '2016-02-03 10:35:01'),
(4, 'common', 0, 'Управление языками', 'Languages', 'Управление языками', '2016-02-04 06:55:17'),
(5, 'common', 0, 'Добавить язык', 'Add a language', 'Добавить язык', '2016-02-04 06:55:17'),
(6, 'common', 0, 'Статус', 'Status', 'Статус', '2016-02-04 06:55:17'),
(7, 'common', 0, 'по умолчанию', 'By default', 'По умолчанию', '2016-02-04 06:55:17'),
(8, 'common', 0, 'Язык', 'Language', 'Язык', '2016-02-04 06:55:17'),
(9, 'common', 0, 'Вы действительно хотите удалить выбранный элемент?', 'Are you sure you want to remove the chosen element?', 'Вы действительно хотите удалить выбранный элемент?', '2016-02-04 06:55:53'),
(10, 'common', 0, 'Переместить элемент ниже', 'Move an item down', 'Переместить элемент ниже', '2016-02-04 06:55:17'),
(11, 'common', 0, 'Переместить элемент выше', 'Move an item up', 'Переместить элемент выше', '2016-02-04 06:55:17'),
(12, 'common', 0, 'Код языка ISO 639-1', 'Language code ISO 639-1', 'Код языка ISO 639-1', '2016-02-04 06:55:17'),
(13, 'common', 0, 'Активно', 'Active', 'Активно', '2016-02-04 06:55:17'),
(14, 'common', 0, 'Скопировать данные из', 'Copy data from', 'Скопировать данные из', '2016-02-04 06:55:17'),
(15, 'common', 0, 'E-mail администратору', 'Administrator e-mail', 'E-mail администратору', '2016-02-04 06:55:17'),
(16, 'common', 0, 'Флаг', 'Flag', 'Флаг', '2016-02-04 06:55:17'),
(17, 'common', 0, 'Наименование', 'Name', 'Наименование', '2016-02-04 06:56:31'),
(19, 'common', 0, 'Деактивировать', 'Deactivate', 'Деактивировать', '2016-02-04 06:55:17'),
(20, 'common', 0, 'Панель администратора', 'Dashboard', 'Панель администратора', '2016-02-04 06:56:13'),
(21, 'common', 0, 'Выход', 'Log out', 'Выход', '2016-02-04 06:55:17'),
(22, 'common', 0, 'Языки', 'Languages', 'Языки', '2016-02-04 07:31:27'),
(23, 'common', 0, 'Управление меню', 'Top menu items', 'Управление верхним меню', '2016-02-04 07:32:20'),
(24, 'common', 0, 'Информационные страницы', 'Info pages', 'Информационные страницы', '2016-02-04 06:55:17'),
(25, 'common', 0, 'Отзывы', 'Reviews', 'Отзывы', '2016-02-04 06:55:17'),
(26, 'common', 0, 'Управление отзывами', 'Reviews management', 'Управление отзывами', '2016-02-04 06:55:17'),
(27, 'common', 0, 'Добавить отзыв', 'Add a review', 'Добавить отзыв', '2016-02-04 06:55:17'),
(28, 'common', 0, 'Новости', 'News', 'Новости', '2016-02-04 06:55:17'),
(29, 'common', 0, 'Добавить новость', 'Add news item', 'Добавить новость', '2016-02-04 07:32:52'),
(30, 'common', 0, 'Статьи', 'Articles', 'Статьи', '2016-02-04 07:33:27'),
(31, 'common', 0, 'Добавить статью', 'Add article', 'Добавить статью', '2016-02-04 07:34:18'),
(32, 'common', 0, 'Галерея', 'Gallery', 'Галерея', '2016-02-04 07:34:37'),
(33, 'common', 0, 'Добавить изображение', 'Add an image', 'Добавить изображение', '2016-02-04 06:55:17'),
(34, 'common', 0, 'Управление категориями', 'Categories of references', 'Управление категориями', '2016-02-04 06:55:17'),
(35, 'common', 0, 'Добавить категорию', 'Add a category', 'Добавить категорию', '2016-02-04 06:55:17'),
(36, 'common', 0, 'Каталог', 'Catalog', 'Каталог', '2016-02-04 07:34:46'),
(37, 'common', 0, 'Управление подкатегориями', 'Manage subcategories', 'Управление подкатегориями', '2016-02-04 07:35:31'),
(38, 'common', 0, 'Добавить подкатегорию', 'Add category', 'Добавить категорию', '2016-02-04 07:35:03'),
(39, 'common', 0, 'Управление наименованиями', 'Manage items', 'Управление наименованиями', '2016-02-04 07:35:17'),
(40, 'common', 0, 'Добавить наименование', 'Add item', 'Добавить наименование', '2016-02-04 07:35:42'),
(41, 'common', 0, 'Прайс-лист', 'Price', 'Прайс-лист', '2016-02-04 07:35:54'),
(42, 'common', 0, 'Разделители', 'Separators', 'Разделители', '2016-02-04 07:36:08'),
(43, 'common', 0, 'Информация', 'Information', 'Информация', '2016-02-04 07:36:19'),
(44, 'common', 0, 'Настройки', 'Settings', 'Настройки', '2016-02-04 06:55:17'),
(45, 'common', 0, 'Данные администратора', 'Admin info', 'Данные администратора', '2016-02-04 08:13:28'),
(46, 'common', 0, 'Обслуживание сайта', 'Site maintenance ', 'Обслуживание сайта', '2016-02-04 06:55:17'),
(47, 'common', 0, 'Переводы', 'Translations', 'Переводы', '2016-02-04 07:52:03'),
(48, 'common', 0, 'Загрузка содержимого ...', 'Content is loading ...', 'Загрузка содержимого ...', '2016-02-04 07:01:22'),
(49, 'common', 0, 'Обновление языка', 'Edit the language', 'Обновление языка', '2016-02-04 06:55:17'),
(56, 'common', 0, 'Перевести', 'Translate', 'Перевести', '2016-02-04 06:55:17'),
(57, 'common', 0, 'Скопировать во все языки', 'Copy to all languages', 'Скопировать во все языки', '2016-02-04 06:55:17'),
(58, 'common', 0, 'Сохранить', 'Save', 'Сохранить', '2016-02-04 06:55:17'),
(59, 'common', 0, 'Homepage', 'Homepage', 'Главная страница', '2016-02-04 07:01:36'),
(60, 'common', 0, 'Главная страница', 'Home', 'Главная страница', '2016-02-04 06:55:17'),
(61, 'common', 0, 'Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.', 'The required fields are marked with an asterisk (<span class="required">*</span>).', 'Поля, отмеченные <span class="required">*</span>, являются обязательными для заполнения.', '2016-02-04 06:55:17'),
(62, 'common', 0, 'Основное', 'Main', 'Основное', '2016-02-04 07:02:13'),
(63, 'common', 0, 'SEO', 'SEO', 'SEO', '2016-02-04 06:55:17'),
(64, 'common', 0, 'Введите значение для данного языка', 'Enter a value for this language', 'Введите значение для данного языка', '2016-02-04 06:55:17'),
(65, 'common', 0, 'Ошибка перевода', 'Error translate', 'Ошибка перевода', '2016-02-04 06:55:17'),
(66, 'common', 0, 'Успешный перевод', 'Successful translation', 'Успешный перевод', '2016-02-04 06:55:17'),
(67, 'common', 0, 'Успешно скопировано', 'Successfully copied', 'Успешно скопировано', '2016-02-04 06:55:17'),
(68, 'common', 0, 'Файлы кэша в папке {folder} были успешно удалены', 'Cache files in folder {folder} were successfully deleted.', 'Файлы кэша в папке {folder} были успешно удалены', '2016-02-04 06:55:17'),
(69, 'common', 0, '{label} is too short for {lang} (minimum is {min} characters).', '{label} is too short for {lang} (minimum is {min} characters).', '{label} слишком короткий для языка {lang} (Минимум: {min} симв.).', '2016-02-02 10:29:01'),
(70, 'common', 0, '{label} is too long for {lang} (maximum is {max} characters).', '{label} is too long for {lang} (maximum is {max} characters).', '{label} слишком длинный для языка {lang} (Максимум: {max} симв.).', '2016-02-02 10:28:37'),
(71, 'common', 0, '{label} is of the wrong length for {lang} (should be {length} characters).', '{label} is of the wrong length for {lang} (should be {length} characters).', '{label} неверной длины для языка {lang} (Должен быть {length} симв.).', '2016-02-02 10:28:56'),
(72, 'common', 0, 'Управление переводами', 'Translations', 'Управление переводами', '2016-02-04 06:55:17'),
(73, 'common', 0, 'Добавить перевод', 'Add a translation', 'Добавить перевод', '2016-02-04 06:55:17'),
(74, 'common', 0, 'Переведено', 'Translated', 'Переведено', '2016-02-04 06:55:17'),
(75, 'common', 0, 'Не переведено', 'Not translated', 'Не переведено', '2016-02-04 06:55:17'),
(76, 'common', 0, 'Значение константы (перевод)', 'Constant''s value (translation)', 'Значение константы (перевод)', '2016-02-04 06:55:17'),
(77, 'common', 0, 'Success', 'Have saved it successfully', 'Успешно сохранили', '2016-02-04 07:02:03'),
(80, 'common', 0, 'Категория', 'Category', 'Категория', '2016-02-04 06:55:17'),
(81, 'common', 0, 'Строковая константа (задается в коде)', 'String constant (defined in the code)', 'Строковая константа (задается в коде)', '2016-02-04 06:55:17'),
(82, 'common', 0, 'Дата обновления', 'Last updated on', 'Дата обновления', '2016-02-04 06:55:17'),
(83, 'common', 0, 'Наверх', 'Go up', 'Наверх', '2016-02-04 06:32:31'),
(84, 'common', 0, 'Администрирование', 'Administration', 'Администрирование', '2016-02-04 06:55:17'),
(85, 'common', 0, 'Управление галереей', 'Manage gallery', 'Управление галереей', '2016-02-04 07:52:18'),
(86, 'common', 0, '{file} имеет неразрешённое расширение файла. Поддерживаются только {extensions}.', '{file} has invalid extension. Only {extensions} are allowed.', '{file} имеет неразрешённое расширение файла. Поддерживаются только {extensions}.', '2016-02-04 08:12:41'),
(87, 'common', 0, '{file} слишком большой, максимальный размер файла {sizeLimit}.', '{file} is too large, maximum file size is {sizeLimit}.', '{file} слишком большой, максимальный размер файла {sizeLimit}.', '2016-02-04 08:13:44'),
(88, 'common', 0, '{file} слишком маленький, минимальный размер файла {minSizeLimit}.', '{file} is too small, minimum file size is {minSizeLimit}.', '{file} слишком маленький, минимальный размер файла {minSizeLimit}.', '2016-02-04 08:14:56'),
(89, 'common', 0, '{file} пустой, пожалуйста выберите другой файл.', '{file} is empty, please select files again without it.', '{file} пустой, пожалуйста выберите другой файл.', '2016-02-04 08:15:09'),
(90, 'common', 0, 'Файл загружается, если вы покинете страницу, то закачка будет отменена.', 'The files are being uploaded, if you leave now the upload will be cancelled.', 'Файл загружается, если вы покинете страницу, то закачка будет отменена.', '2016-02-04 08:16:04'),
(91, 'common', 0, 'Сохранить описание', 'Save description', 'Сохранить описание', '2016-02-04 08:16:16'),
(92, 'common', 0, 'Управление информационными страницами', 'Infopages managment', 'Управление информационными страницами', '2016-02-04 06:55:17'),
(93, 'common', 0, 'Добавить страницу', 'Add a page', 'Добавить страницу', '2016-02-04 06:55:17'),
(94, 'common', 0, 'В этой секции Вы можете добавлять страницы, которые в дальнейшем можно либо разместить в меню, либо указывать ссылки в содержимом другой страницы.', 'In this section you can add pages that you can put either in the menu or indicate links in the content of another pages.', 'В этой секции Вы можете добавлять страницы, которые в дальнейшем можно либо разместить в меню, либо указывать ссылки в содержимом другой страницы.', '2016-02-04 06:55:17'),
(95, 'common', 0, 'ID', 'ID', 'ID', '2016-02-04 06:55:17'),
(96, 'common', 0, 'Заголовок страницы', 'Page Title', 'Заголовок страницы', '2016-02-04 06:55:17'),
(97, 'common', 0, 'Содержимое страницы', 'Page content', 'Содержимое страницы', '2016-02-04 06:55:17'),
(98, 'common', 0, 'Дата добавления', 'Date created', 'Дата добавления', '2016-02-04 06:55:17'),
(99, 'common', 0, 'Отобразить снизу страницы', 'Display at the bottom of the page', 'Отобразить снизу страницы', '2016-02-04 06:55:17'),
(100, 'common', 0, 'Title страницы (для SEO)', 'Meta title ( for SEO )', 'Title страницы (для SEO)', '2016-02-04 08:16:50'),
(101, 'common', 0, 'Keywords страницы (для SEO)', 'Meta keywords ( for SEO )', 'Keywords страницы (для SEO)', '2016-02-04 08:17:03'),
(102, 'common', 0, 'Description страницы (для SEO)', 'Meta description ( for SEO )', 'Description страницы (для SEO)', '2016-02-04 08:17:09'),
(103, 'common', 0, 'Переместить выше', 'Move an item up', 'Переместить элемент выше', '2016-02-04 08:08:46'),
(104, 'common', 0, 'Переместить ниже', 'Move an item down', 'Переместить элемент ниже', '2016-02-04 08:08:52'),
(105, 'common', 0, 'Имя', 'Name', 'Имя', '2016-02-04 06:55:17'),
(106, 'common', 0, 'Отзыв', 'Review', 'Отзыв', '2016-02-04 08:08:17'),
(107, 'common', 0, 'Проверочный код', 'Verify code', 'Проверочный код', '2016-02-04 06:55:17'),
(108, 'common', 0, 'Активировать', 'Activate', 'Активировать', '2016-02-04 06:55:17'),
(109, 'common', 0, 'Удалить', 'Delete', 'Удалить', '2016-02-04 06:55:17'),
(110, 'common', 0, 'Управление новостями', 'News ', 'Управление новостями', '2016-02-04 06:55:17'),
(111, 'common', 0, 'Заголовок новости', 'News title', 'Заголовок новости', '2016-02-04 08:18:18'),
(112, 'common', 0, 'Текст новости', 'Page content', 'Содержимое страницы', '2016-02-04 08:22:48'),
(113, 'common', 0, 'Короткий текст новости', 'Announce', 'Анонс', '2016-02-04 08:23:09'),
(114, 'common', 0, 'Управление статьями', 'Manage articles', 'Управление статьями', '2016-02-04 08:23:35'),
(115, 'common', 0, 'Заголовок статьи', 'Article title', 'Заголовок статьи', '2016-02-04 08:23:49'),
(116, 'common', 0, 'Текст статьи', 'Page content', 'Текст статьи', '2016-02-04 08:24:18'),
(117, 'common', 0, 'Короткий текст статьи', 'Announce', 'Короткий текст статьи', '2016-02-04 08:24:19'),
(118, 'common', 0, 'Дата создания', 'Date of creation', 'Дата создания', '2016-02-04 06:55:17'),
(119, 'common', 0, 'Изображение', 'Image', 'Изображение', '2016-02-04 06:55:17'),
(120, 'common', 0, 'Описание', 'Description', 'Описание', '2016-02-04 06:55:17'),
(121, 'common', 0, 'Порядок', 'Sorter', 'Порядок', '2016-02-04 07:50:48'),
(122, 'common', 0, 'Список категорий', 'List of categories', 'Список категорий', '2016-02-04 07:54:12'),
(123, 'common', 0, 'Название категории', 'Category name', 'Название категории', '2016-02-04 06:55:17'),
(124, 'common', 0, 'Дата изменения', 'Last updated on', 'Дата изменения', '2016-02-04 06:55:17'),
(125, 'common', 0, 'Управление каталогом товаров', 'Manage catalog', 'Управление каталогом товаров', '2016-02-04 08:24:02'),
(126, 'common', 0, 'Список подкатегорий', 'List of subcategories', 'Список подкатегорий', '2016-02-04 07:59:49'),
(127, 'common', 0, 'Название подкатегории', 'The name of the subcategory', 'Название подкатегории', '2016-02-04 06:30:36'),
(128, 'common', 0, 'Добавить подкатегорию', 'Add subcategory', 'Добавить подкатегорию', '2016-02-04 07:59:34'),
(129, 'common', 0, 'Управление товарами', 'Manage products', 'Управление товарами', '2016-02-04 08:28:08'),
(130, 'common', 0, 'Список наименований', 'List of items', 'Список наименований', '2016-02-04 07:54:00'),
(131, 'common', 0, 'Подкатегория', 'Subcategory', 'Подкатегория', '2016-02-04 07:53:46'),
(132, 'common', 0, 'Название', 'Name', 'Название', '2016-02-04 09:21:29'),
(133, 'common', 0, 'Цена', 'Price', 'Цена', '2016-02-04 06:55:17'),
(134, 'common', 0, 'Добавить', 'Add', 'Добавить', '2016-02-04 06:55:17'),
(135, 'common', 0, 'Управление прайс-листом', 'Manage price', 'Управление прайс-листом', '2016-02-04 07:53:22'),
(136, 'common', 0, 'Добавить разделитель', 'Add separator', 'Добавить разделитель', '2016-02-04 07:53:12'),
(137, 'common', 0, '№', 'ID', '№', '2016-02-04 06:55:17'),
(138, 'common', 0, 'Разделитель', 'Separator', 'Разделитель', '2016-02-04 07:50:15'),
(139, 'common', 0, 'Текст в разделителе', 'Text in separator', 'Текст в разделителе', '2016-02-04 07:53:35'),
(140, 'common', 0, 'Выделить жирным текстом', 'Make text bold', 'Выделить жирным текстом', '2016-02-04 07:52:45'),
(141, 'common', 0, 'Управление разделителями', 'Manage separators', 'Управление разделителями', '2016-02-04 07:52:59'),
(142, 'common', 0, 'Сортировка', 'Sorter', 'Сортировка', '2016-02-04 07:08:40'),
(143, 'common', 0, 'Управление информацией', 'Manage info', 'Управление информацией', '2016-02-04 07:09:03'),
(144, 'common', 0, 'Тип', 'Type', 'Тип', '2016-02-04 06:55:17'),
(145, 'common', 0, 'Текст', 'Text', 'Текст', '2016-02-04 06:55:17'),
(146, 'common', 0, 'Редактировать информацию', 'Edit info', 'Редактировать информацию', '2016-02-04 07:22:52'),
(147, 'common', 0, 'Управление настройками', 'Settings', 'Управление настройками', '2016-02-04 06:55:17'),
(148, 'common', 0, 'Значение', 'Value', 'Значение', '2016-02-04 06:55:17'),
(152, 'common', 0, 'Редактировать новость', 'Edit news item', 'Редактировать новость', '2016-02-04 07:30:00'),
(153, 'common', 0, 'Редактировать настройки', 'Edit settings', 'Редактировать настройки', '2016-02-04 07:22:59'),
(154, 'common', 0, 'Редактировать параметр настройки', 'Edit setting', 'Редактировать параметр настройки', '2016-02-04 07:23:03'),
(155, 'common', 0, 'Изменить', 'Change', 'Изменить', '2016-02-04 06:55:17'),
(156, 'common', 0, 'Страница', 'Page', 'Страница', '2016-02-04 06:55:17'),
(157, 'common', 0, 'Закрыт на обслуживание', 'Closed for maintenance', 'Закрыт на обслуживание', '2016-02-04 06:55:17'),
(158, 'common', 0, 'Открыт для IP', 'Allow from IP', 'Открыт для IP', '2016-02-04 06:55:17'),
(160, 'common', 0, 'Редактирование перевода', 'Edit the translation', 'Редактирование перевода', '2016-02-04 06:55:17'),
(161, 'common', 0, 'Редактировать пункт меню', 'Edit menu item', 'Редактировать пункт меню', '2016-02-04 07:23:06'),
(162, 'common', 0, 'Управление пунктами меню', 'Top menu items', 'Управление пунктами меню', '2016-02-04 06:55:17'),
(163, 'common', 0, 'Текст ссылки', 'Text links', 'Текст ссылки', '2016-02-04 06:55:17'),
(164, 'common', 0, 'Тип ссылки', 'Type of link', 'Тип ссылки', '2016-02-04 06:55:17'),
(165, 'common', 0, 'Ссылка', 'Link', 'Ссылка', '2016-02-04 06:55:17'),
(166, 'common', 0, 'Родительский элемент', 'Parent''s element', 'Родительский элемент', '2016-02-04 06:55:17'),
(167, 'common', 0, 'Позиция', 'Position', 'Позиция', '2016-02-04 06:55:17'),
(168, 'common', 0, 'Открывать в новом окне', 'Open in a new browser window', 'Открывать в новом окне браузера', '2016-02-04 07:22:46'),
(169, 'common', 0, 'Редактировать страницу', 'Edit the page', 'Редактировать страницу', '2016-02-04 06:55:17'),
(170, 'common', 0, 'Удалить страницу', 'Delete the page', 'Удалить страницу', '2016-02-04 06:55:17'),
(171, 'common', 0, 'Неактивно', 'Inactive', 'Неактивно', '2016-02-04 06:55:17'),
(172, 'common', 0, 'Редактировать отзыв', 'Edit a review', 'Редактировать отзыв', '2016-02-04 06:55:17'),
(173, 'common', 0, 'Удалить отзыв', 'Delete review', 'Удалить отзыв', '2016-02-04 06:55:17'),
(174, 'common', 0, 'Просмотр отзыва', 'Watch review', 'Просмотр отзыва', '2016-02-04 06:55:17'),
(175, 'common', 0, 'Удалить новость', 'Delete the news', 'Удалить новость', '2016-02-04 07:24:24'),
(176, 'common', 0, 'Редактировать статью', 'Edit article', 'Редактировать статью', '2016-02-04 07:24:33'),
(177, 'common', 0, 'Удалить статью', 'Delete the article', 'Удалить статью', '2016-02-04 07:24:35'),
(178, 'common', 0, 'Редактировать описание к изображению', 'Edit description', 'Редактировать описание к изображению', '2016-02-04 07:24:59'),
(179, 'common', 0, 'Удалить изображение', 'Delete the image', 'Удалить изображение', '2016-02-04 06:55:17'),
(180, 'common', 0, 'Редактировать категорию', 'Edit category', 'Редактировать категорию', '2016-02-04 06:55:17'),
(181, 'common', 0, 'Удалить категорию', 'Delete the category', 'Удалить категорию', '2016-02-04 06:55:17'),
(182, 'common', 0, 'Редактировать подкатегорию', 'Edit subcategory', 'Редактировать подкатегорию', '2016-02-04 07:26:28'),
(183, 'common', 0, 'Удалить подкатегорию', 'Delete the subcategory', 'Удалить подкатегорию', '2016-02-04 07:26:43'),
(184, 'common', 0, 'Редактировать подкатегорию', 'Edit subcategory', 'Редактировать подкатегорию', '2016-02-04 07:27:08'),
(185, 'common', 0, 'Редактировать наименование', 'Edit item', 'Редактировать наименование', '2016-02-04 07:30:20'),
(186, 'common', 0, 'Редактировать', 'Update', 'Редактировать', '2016-02-04 06:55:17'),
(187, 'common', 0, 'Удалить наименование', 'Delete the item', 'Удалить наименование', '2016-02-04 07:30:23'),
(188, 'common', 0, 'ID позиции(наименования)', 'ID item', 'ID позиции(наименования)', '2016-02-04 07:30:37'),
(189, 'common', 0, 'Вы можете загрузить свои иконки флагов в директорию flag_dir, и они будут доступны для выбора', 'You can download your flag icons into the directory flag_dir, so they will be able to be chosen.', 'Вы можете загрузить свои иконки флагов в директорию flag_dir, и они будут доступны для выбора', '2016-02-04 06:55:17'),
(190, 'common', 0, 'Не копировать', 'Do not copy', 'Не копировать', '2016-02-04 06:55:17'),
(191, 'common', 0, 'Ошибка. Повторите запрос позднее', 'Error. Repeat attempt later', 'Ошибка. Повторите запрос позднее', '2016-02-04 06:55:17'),
(192, 'common', 0, 'Введите требуемое значение', 'Enter the required value', 'Введите требуемое значение', '2016-02-04 06:55:17'),
(193, 'common', 0, '{label} cannot be blank for {lang}.', '{label} cannot be blank for {lang}.', 'Необходимо заполнить поле {label} для языка {lang}.', '2016-02-04 07:09:42'),
(194, 'common', 0, 'Очистить папку assets', 'Clear folder "assets"', 'Очистить папку "assets"', '2016-02-04 07:10:00'),
(195, 'common', 0, 'Очистить папку runtime', 'Clear folder "runtime"', '''Очистить папку "runtime"', '2016-02-04 07:10:17'),
(196, 'common', 0, 'Через запятую', 'Separated by commas', 'Через запятую', '2016-02-04 06:55:17'),
(197, 'common', 0, 'Вы действительно хотите очистить выбранный кэш?', 'Are you sure you want to empty the cache?', 'Вы действительно хотите очистить выбранный кэш?', '2016-02-04 07:10:36'),
(198, 'common', 0, 'На наименовании пункта меню кликните правой клавишей мыши и увидите контекстное меню с доступными действиями. Максимум можно добавить 3 уровня. Есть возможность  зажать левую клавишу мыши и перемещать элементы меню вверх и вниз.', 'If you right-click on the name of the menu item, you can see the context menu with available actions. You can add max. 3 levels. There is also an opportunity to hold the left mouse button and move the menu items up and down.', 'На наименовании пункта меню кликните правой клавишей мыши и увидите контекстное меню с доступными действиями. Максимум можно добавить 3 уровня. Есть возможность  зажать левую клавишу мыши и перемещать элементы меню вверх и вниз.', '2016-02-04 06:55:17'),
(199, 'common', 0, 'Невозможно редактировать данный раздел', 'Editing of this section is not allowed', 'Невозможно редактировать данный раздел', '2016-02-04 06:55:17'),
(200, 'common', 0, 'Error', 'Error', 'Ошибка', '2016-02-04 07:10:46'),
(201, 'common', 0, 'Родительский узел не был создан, повторите попытку позже.', 'The parent node wasn''t created. Please try again later.', 'Родительский узел не был создан, повторите попытку позже.', '2016-02-04 06:55:17'),
(202, 'common', 0, 'Введите название пункта меню', 'Enter the name of the menu item', 'Введите название пункта меню', '2016-02-04 06:55:17'),
(203, 'common', 0, 'Ошибка', 'Error', 'Ошибка', '2016-02-04 06:55:17'),
(204, 'common', 0, 'Вы действительно хотите переименовать пункт меню', 'Dou you really want to rename menu item', 'Вы действительно хотите переименовать пункт меню', '2016-02-04 06:55:17'),
(205, 'common', 0, 'в', 'in', 'в', '2016-02-04 06:55:17'),
(206, 'common', 0, 'Переименовать пункт меню', 'Rename menu item', 'Переименовать пункт меню', '2016-02-04 06:55:17'),
(207, 'common', 0, 'Создать внутри', 'Create inside', 'Создать внутри', '2016-02-04 06:55:17'),
(208, 'common', 0, 'Переименовать', 'Rename', 'Переименовать', '2016-02-04 06:55:17'),
(209, 'common', 0, 'Удалить', 'Delete', 'Удалить', '2016-02-04 06:55:17'),
(210, 'common', 0, 'Редактировать', 'Update', 'Редактировать', '2016-02-04 06:55:17'),
(211, 'common', 0, 'Загрузка ...', 'Loading ...', 'Загрузка ...', '2016-02-04 06:55:17'),
(212, 'common', 0, 'Ничего', 'Nothing', 'Ничего', '2016-02-04 06:55:17'),
(213, 'common', 0, 'Простая ссылка (задаётся вручную)', 'A simple link (set manually)', 'Простая ссылка (задается вручную)', '2016-02-04 06:55:17'),
(214, 'common', 0, 'Информационная страница', 'Infopage', 'Информационная страница', '2016-02-04 07:11:04'),
(215, 'common', 0, 'Нет', 'No', 'Нет', '2016-02-04 06:55:17'),
(216, 'common', 0, 'Каталог товаров', 'Catalog', 'Каталог товаров', '2016-02-04 07:12:55'),
(217, 'common', 0, 'Форма "Свяжитесь с нами"', 'The form of the section "Contact Us"', 'Форма "Свяжитесь с нами"', '2016-02-04 09:34:25'),
(218, 'common', 0, 'Просмотр новости', 'View news', 'Просмотр новости', '2016-02-04 07:12:38'),
(219, 'common', 0, 'Успешно сохранено', 'Has been saved successfully', 'Успешно сохранено', '2016-02-04 06:55:17'),
(220, 'common', 0, 'Поиск', 'Search', 'Поиск', '2016-02-04 06:27:29'),
(221, 'common', 0, 'Включите поддержку JavaScript в Вашем браузере для комфортной работы с сайтом.', 'Allow javascript in your browser for comfortable use site.', 'Разрешите JavaScript в вашем браузере для комфортного использования сайта.', '2016-02-04 07:08:27'),
(222, 'common', 0, 'О нас', 'About us', 'О нас', '2016-02-04 06:46:20'),
(223, 'common', 0, 'Категории', 'Categories', 'Категории', '2016-02-04 06:29:33'),
(224, 'common', 0, 'Контакты', 'Contact us', 'Контакты', '2016-02-04 06:31:06'),
(225, 'common', 0, 'Минимум', 'Minimum', 'Минимум', '2016-02-04 07:07:53'),
(226, 'common', 0, 'символа', 'characters', 'символа', '2016-02-04 07:07:52'),
(227, 'common', 0, 'Акция', 'Special offer', 'Акция', '2016-02-04 07:06:51'),
(228, 'common', 0, 'Страница 404', 'Page 404', 'Страница 404', '2016-02-04 07:06:31'),
(229, 'common', 0, 'Слоган', 'Slogan', 'Слоган', '2016-02-04 07:07:24'),
(230, 'common', 0, 'Добавление', 'Add', 'Добавление', '2016-02-04 07:06:20'),
(231, 'common', 0, 'Email', 'Email', 'Email', '2016-02-04 06:55:17'),
(232, 'common', 0, 'Телефон', 'Phone', 'Телефон', '2016-02-04 06:55:17'),
(233, 'common', 0, 'Skype', 'Skype', 'Skype', '2016-02-04 06:55:17'),
(234, 'common', 0, 'ICQ', 'ICQ', 'ICQ', '2016-02-04 06:55:17'),
(235, 'common', 0, 'Адрес', 'Address', 'Адрес', '2016-02-04 06:55:17'),
(236, 'common', 0, 'Вы можете заполнить форму ниже для связи с нами.', 'You can fill out the form below to contact us.', 'Вы можете заполнить форму ниже для связи с нами.', '2016-02-04 06:55:17'),
(237, 'common', 0, 'Сообщение', 'Message', 'Сообщение', '2016-02-04 06:55:17'),
(238, 'common', 0, 'Послать сообщение', 'Send message', 'Послать сообщение', '2016-02-04 06:55:17'),
(239, 'common', 0, 'Запомнить меня', 'Remember me next time', 'Запомнить меня', '2016-02-04 06:55:17'),
(240, 'common', 0, 'Адрес электронной почты', 'E-mail', 'Адрес электронной почты', '2016-02-04 06:55:17'),
(241, 'common', 0, 'Пароль', 'Password', 'Пароль', '2016-02-04 06:55:17'),
(242, 'common', 0, 'Неверный логин или пароль', 'Incorrect login or password', 'Неверный логин или пароль', '2016-02-04 07:03:31'),
(243, 'common', 0, 'Случайные', 'Random items', 'Случайные', '2016-02-04 08:27:24'),
(244, 'common', 0, 'Результаты поиска', 'Search results', 'Результаты поиска', '2016-02-04 06:27:50'),
(245, 'common', 0, 'По данному запросу ничего не найдено.', 'Nothing', 'По данному запросу ничего не найдено.', '2016-02-04 07:05:31'),
(246, 'common', 0, 'Подробнее &#8594', 'Read more &#8594', 'Подробнее &#8594', '2016-02-04 07:06:03'),
(247, 'common', 0, 'Читать дальше &#8594;', 'Read more &#8594', 'Читать дальше &#8594;', '2016-02-04 07:06:10'),
(248, 'common', 0, 'Вход', 'Login', 'Вход', '2016-02-04 07:50:03'),
(249, 'common', 0, '{label} is too short for {lang} (minimum is {min} characters).', '{label} is too short for {lang} (minimum is {min} characters).', '{label} слишком короткий для языка {lang} (Минимум: {min} симв.).', '2016-02-04 07:51:39'),
(250, 'common', 0, 'Прежний пароль', 'Current admin password', 'Текущий пароль администатора', '2016-02-04 07:57:03'),
(251, 'common', 0, 'Повторите пароль', 'Repeat password', 'Повторите пароль', '2016-02-04 07:56:18'),
(252, 'common', 0, '{label} is too long for {lang} (maximum is {max} characters).', '{label} is too long for {lang} (maximum is {max} characters).', '{label} слишком длинный для языка {lang} (Максимум: {max} симв.).', '2016-02-04 07:54:43'),
(253, 'common', 0, '{label} is of the wrong length for {lang} (should be {length} characters).', '{label} is of the wrong length for {lang} (should be {length} characters).', '{label} неверной длины для языка {lang} (Должен быть {length} симв.).', '2016-02-04 07:55:25'),
(254, 'common', 0, 'С отмеченными', 'With a tick', 'С отмеченными', '2016-02-04 09:22:09'),
(255, 'common', 0, 'Выполнить', 'Ok', 'Выполнить', '2016-02-04 09:21:54'),
(256, 'common', 0, 'Вы уверены?', 'Are you sure?', 'Вы уверены?', '2016-02-04 09:22:40'),
(257, 'common', 0, 'Да', 'Yes', 'Да', '2016-02-04 09:22:25'),
(258, 'common', 0, 'Отмена', 'Cancel', 'Отмена', '2016-02-04 09:22:18'),
(259, 'common', 0, 'Главное меню', 'Main menu', 'Главное меню', '2016-02-04 09:24:19'),
(260, 'common', 0, 'Ошибка 404', 'Error 404', 'Ошибка 404', '2016-02-04 09:42:05'),
(261, 'common', 0, 'Вы действительно хотите удалить пункт меню', 'Do you really want to remove the menu item', 'Вы действительно хотите удалить пункт меню', '2016-02-04 09:45:11'),
(262, 'common', 0, 'и всех его потомков?', 'and all its descendants?', 'и всех его потомков?', '2016-02-04 09:45:09'),
(263, 'common', 0, 'Удалить пункт меню', 'Delete a menu item', 'Удалить пункт меню', '2016-02-04 09:45:06'),
(264, 'common', 0, 'Отзыв успешно отправлен и будет доступен после модерации.', 'The review was successfully sent and will be available after moderation.', 'Отзыв успешно отправлен и будет доступен после модерации.', '2016-02-04 09:58:13'),
(265, 'common', 0, 'Сообщение не было отправлено! Исправьте, пожалуйста, ошибки и повторите снова.', 'The message is not sent! Please correct the mistakes and try again.', 'Сообщение не было отправлено! Исправьте, пожалуйста, ошибки и повторите снова.', '2016-02-04 10:01:17'),
(266, 'common', 0, 'Спасибо за связь с нами! Мы ответим Вам как можно быстрее.', 'Thanks for message! We will answer you as soon as possible.', 'Спасибо за обращение! Мы ответим Вам как можно быстрее.', '2016-02-04 10:01:39'),
(267, 'common', 0, 'Other_author_scripts', 'Other author''s scripts', 'Другие скрипты разработчика', '2016-02-14 07:35:57'),
(268, 'common', 0, 'Supported types of files', 'Supported types of files', 'Поддерживаемый тип файлов', '2016-05-20 13:19:31'),
(269, 'common', 0, 'New message (contact form)', 'New message (contact form)', 'Новое сообщение (форма контактов)', '2016-05-20 13:19:31'),
(270, 'common', 0, 'The new review was added', 'The new review was added', 'Был добавлен новый отзыв', '2016-05-20 13:19:31'),
(271, 'common', 0, 'Cookies are disabled', 'Cookies are disabled', 'Cookies запрещены', '2016-05-20 13:19:31'),
(272, 'common', 0, 'Please, enable cookies in your browser', 'Please, enable cookies in your browser', 'Пожалуйста, разрешите Cookies в вашем браузере', '2016-05-20 13:19:31'),
(273, 'common', 0, 'Privacy Policy', 'Privacy Policy', 'Политика конфиденциальности', '2016-05-20 13:19:31'),
(274, 'common', 0, 'uses cookie', 'uses cookie', 'использует cookie', '2016-05-24 10:12:38');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}users`
--

DROP TABLE IF EXISTS `{dbPrefix}users`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(23) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `{dbPrefix}users`
--

INSERT INTO `{dbPrefix}users` (`id`, `password`, `salt`, `email`) VALUES
(1, '{adminPass}', '{adminSalt}', '{adminEmail}');

-- --------------------------------------------------------

--
-- Структура таблицы `{dbPrefix}users_sessions`
--

DROP TABLE IF EXISTS `{dbPrefix}users_sessions`;
CREATE TABLE IF NOT EXISTS `{dbPrefix}users_sessions` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`),
  KEY `yiisession_expire_idx` (`expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
