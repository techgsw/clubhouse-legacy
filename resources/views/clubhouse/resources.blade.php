@extends('layouts.clubhouse')
@section('title', 'Sports Industry Resources')
@section('hero')
    <div class="row hero bg-image services">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/resources-white.png" />
            <h4 class="header">Sports Industry Resources</h4>
            <p>Rising tides raise all ships! Check out other sports industry resources that can also help you achieve success in sports.</p>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                @include('layouts.components.messages')
                @include('layouts.components.errors')
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <p><a href="#sports-media">Sports Media</a> | <a href="#groups">Groups</a> | <a href="#events">Events</a> | <a href="#education">Education</a> | <a href="#books">Books</a> | <a href="#career-advice">Career Advice</a> | <a href="#sports-tech">Sports Tech</a> | <a href="#whitepapers">Whitepapers</a> | <a href="#organizations">Organizations</a></p>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <h4 id="sports-media"><span class="sbs-red-text">Sports Media</span></h4>
                <h5>Publications, podcasts, newsletters and more</h5>
                <ul class="browser-default">
                    <li><a target="_blank" href="https://www.sportsbusinessdaily.com/Journal.aspx">Sports Business Journal</a> - the go to publication and daily resource for leaders across the sports industry</li>
                    <li><a target="_blank" href="https://hashtagsports.com/">Hashtag Sports</a> - newsletter on the new sports economy and ecosystem</li>
                    <li><a target="_blank" href="https://frntofficesport.com/">Front Office Sports</a> - refreshing takes on the intersection of sports and business</li>
                    <li><a target="_blank" href="https://www.sporttechie.com/">Sporttechie</a> - tech focused sports business newsletter</li>
                    <li><a target="_blank" href="https://www.theplayerstribune.com/en-us">The Players’ Tribune</a> - new media company that shares athletes stories in their own words</li>
                    <li><a target="_blank" href="https://www.uninterrupted.com/">UNINTERRUPTED</a> - video and podcasts from athletes</li>
                    <li><a target="_blank" href="http://acemediaco.com/">Athlete Content and Entertainment (ACE) Media</a> - production company focused on athlete driven content</li>
                    <li><a target="_blank" href="https://www.unscriptd.com/">UNSCRIPTD</a> - publishing platform for athletes</li>
                    <li><a target="_blank" href="http://www.flosports.tv/">Flosports</a> - OTT network for live and digital sports programming</li>
                    <li><a target="_blank" href="https://bleacherreport.com/">Bleacher Report</a> - leading sports news and highlights company</li>
                    <li><a target="_blank" href="http://www.thebusinessofsports.com/">Business of Sports</a> - website focused on content for the business of sports</li>
                </ul>
                <h4 id="groups">Groups</h4>
                <h5>Local and national groups for those interested in or working in sports</h5>
                <ul class="browser-default">
                    <li><a target="_blank" href="https://sportsmarketingnetwork.com/">Sports Marketing Network</a> - more than 11,000 individual and corporate members with chapters in major markets and members in more than 50 U.S. cities</li>
                    <li><a target="_blank" href="http://www.sportmarketingassociation.com/">Sport Marketing Association</a> - forum for practitioners, academics, and students dedicated to the sport marketing industry</li>
                    <li><a target="_blank" href="http://www.wiseworks.org/">Women in Sports and Events</a> - leading voice and resource for professional women in the business of sports</li>
                    <li><a target="_blank" href="http://www.nacda.com/nacda/nacda-overview.html">NACDA</a> - the professional association for those in the field of athletics administration
                        <ul class="browser-default">
                            <li><a target="_blank" href="http://www.nacda.com/naatso/nacda-naatso.html">NAATSO</a> - ticketing specific group within NACDA</li>
                        </ul>
                    </li>
                </ul>
                <h4 id="events">Events</h4>
                <h5>Sports industry conferences for networking, education, and personal development</h5>
                <ul class="browser-default">
                    <li><a target="_blank" href="https://websummit.com/sports-trade">Sports Trade</a> - SportsTrade is the world’s largest sports business conference, connecting the owners of the world’s leading franchises, media companies, sports stars, retailers, brands and tech companies</li>
                    <li><a target="_blank" href="http://www.thebusinessofsports.com/events/2018-caa-world-congress-of-sports/">CAA World Congress of Sports</a> - insights and opinions on the business of sports</li>
                    <li><a target="_blank" href="https://www.alsd.com/">ALSD</a> - conference focused on premium seat and suite sellers and managers</li>
                    <li><a target="_blank" href="https://www.sportsbusinessdaily.com/Conferences-Events/2018/SMT.aspx">NeuLion Sports Media and Technology Conference</a> - media and content distribution focused conference</li>
                    <li><a target="_blank" href="https://www.sportsbusinessdaily.com/Conferences-Events/2018/SMS.aspx">Octagon Sports Marketing Symposium</a>  - exploring marketing and sponsorships by the most active brands in sports brands</li>
                    <li><a target="_blank" href="https://www.sportsmanagementworldwide.com/conferences">SMWW Sports Career Conferences</a> - variety of sport specific, career focused, conferences</li>
                    <li><a target="_blank" href="https://leadersinsport.com/leaders-week-new-york/sport-business-summit/">Leaders Sports Business Summit</a> - leaders shaping the future of sport</li>
                    <li><a target="_blank" href="http://www.sponsorship.com/IEG2018.aspx#sthash.Grop3uZH.dpbs">IEG Sponsorship Conference</a> - all things sponsorship</li>
                    <li><a target="_blank" href="http://sportssalesbootcamp.com/">Sports Sales Boot Camp</a> - for the current sports sales professional looking to improve their acumen and get better</li>
                    <li><a target="_blank" href="https://sports-forum.com/">National Sports Forum</a> - largest annual cross-gatherings of business professionals in the sports industry representing a broad spectrum of teams, leagues, agencies and corporate partners</li>
                    <li><a target="_blank" href="http://www.sloansportsconference.com/content/selling-out-understanding-the-path-to-purchase-for-sports-tickets/">MIT Sloan Sports Analytics Conference</a> - discussions on the increasing role of analytics in the global sports industry</li>
                    <li><a target="_blank" href="http://www.nacda.com/convention/nacda-convention.html">NACDA</a> - have a conference every year for college sports professionals to get together to learn and network</li>
                    <li><a target="_blank" href="http://theseme.com/">SEME</a> - premier sports career and networking conference geared toward young professionals</li>
                    <li><a target="_blank" href="http://www.mountunion.edu/sport-sales-workshop-and-job-fair">Mount Union Sales Workshop</a> - top tickets sales recruiting event and workshop in the industry</li>
                    <li><a target="_blank" href="https://danielsummit.com/faith-sports-conference">The Daniel Summit</a> - Faith based sport leadership conference</li>
                </ul>
                <h4 id="education">Education</h4>
                <ul class="browser-default">
                    <li><a target="_blank" href="https://www.sportsbusinessdaily.com/College-University/Sports-Management-Programs.aspx">Sports Business Journal</a> - list of educational programs, complete with contact information</li>
                    <li><a target="_blank" href="https://www.nassm.com/node/128">North American Society for Sport Management</a> - comprehensive list of undergraduate, graduate, and doctoral programs in sports related fields</li>
                </ul>
                <h4 id="books">Books</h4>
                <ul class="browser-default">
                    <li><a target="_blank" href="https://sportsbusinessbookstore.com/">Sports Business Bookstore</a> - a pretty insane list of sports business related reads</li>
                    <li>General / Leadership
                        <ul class="browser-default">
                            <li><a target="_blank" href="https://www.amazon.com/Life-Not-Accident-Memoir-Reinvention/dp/0062327992">Life is not an accident</a> – Jay Williams</li>
                            <li><a target="_blank" href="https://www.amazon.com/Prison-Without-Bars-Pete-Rose/dp/0756785707">My prison without bars</a> – Pete Rose</li>
                            <li><a target="_blank" href="https://www.amazon.com/Art-War-Sun-Tzu/dp/1599869772">Art of War</a> – Sun Tzu</li>
                            <li><a target="_blank" href="https://www.amazon.com/Empire-Business-Andrew-Carnegie/dp/1517172047">The Empire of Business</a> – Andrew Carnegie</li>
                            <li><a target="_blank" href="https://www.amazon.com/Think-Grow-Rich-Resent-Poverty/dp/1503081036">Think and Grow Rich</a> – Napoleon Hill</li>
                            <li><a target="_blank" href="https://www.amazon.com/Crush-Time-Cash-Your-Passion/dp/0061914177">Crush It</a> - Gary Vaynerchuk</li>
                            <li><a target="_blank" href="http://www.theenergybus.com/">The Energy Bus</a> - Jon Gordon</li>
                            <li><a target="_blank" href="https://www.amazon.com/Purple-Cow-New-Transform-Remarkable/dp/1591843170">Purple Cow</a> - Seth Godin</li>
                            <li><a target="_blank" href="https://www.amazon.com/Tools-Titans-Billionaires-World-Class-Performers/dp/1328683788">Tools of Titans</a> - Tim Ferris</li>
                            <li><a target="_blank" href="https://www.amazon.com/Relentless-Unstoppable-Tim-S-Grover/dp/1476714207">Relentless</a> - Tim Grover</li>
                            <li><a target="_blank" href="https://www.amazon.com/Score-Takes-Care-Itself-Philosophy/dp/1591843472">The Score Takes Care of Itself</a> -  Bill Walsh</li>
                            <li><a target="_blank" href="https://www.amazon.com/Leadership-Self-Deception-Getting-Out-Box-ebook/dp/B00GUPYRUS">Leadership and Self Deception</a> - The Arbinger institute</li>
                            <li><a target="_blank" href="https://www.amazon.com/Five-Dysfunctions-Team-Leadership-Fable/dp/0787960756">Five Dysfunctions of a Team</a> -  Patrick Lencioni</li>
                            <li><a target="_blank" href="https://www.amazon.com/Moved-Cheese-Spencer-Johnson-M-D/dp/0743582853">Who Moved My Cheese</a> - Spencer Johnson</li>
                            <li><a target="_blank" href="https://www.amazon.com/How-Win-Friends-Influence-People/dp/0671027034">How to Win Friends and Influence People</a> - Dale Carnegie</li>
                            <li><a target="_blank" href="https://www.amazon.com/10X-Rule-Difference-Between-Success/dp/0470627603">The 10X Rule</a> - Grant Cardone</li>
                            <li><a target="_blank" href="https://www.amazon.com/Slight-Edge-Turning-Disciplines-Massive/dp/193594486X">The Slight Edge</a> - Jeff Olson</li>
                            <li><a target="_blank" href="https://www.amazon.com/Monday-Morning-Choices-Powerful-Extraordinary/dp/0061451916">Monday Morning Choices</a> - David Cottrell</li>
                            <li><a target="_blank" href="https://www.amazon.com/Shoe-Dog-Phil-Knight/dp/1508211809">Shoe Dog</a> - Phil Knight</li>
                            <li><a target="_blank" href="https://www.amazon.com/Kings-Diddy-Jay-Z-Hip-Hops-Multibillion-Dollar/dp/0316316539">3 Kings</a> – Zack O’Malley Greenburg</li>
                            <li><a target="_blank" href="https://www.amazon.com/You-Are-What-Speak-Grouches/dp/0553807870">You Are What You Speak</a> – Robert Lane Green</li>
                        </ul>
                    </li>
                    <li>Sales
                        <ul class="browser-default">
                            <li><a target="_blank" href="https://www.amazon.com/Ice-Eskimos-Market-Product-Nobody/dp/0887308511">Ice to The Eskimos</a> - Jon Spoelstra</li>
                            <li><a target="_blank" href="https://www.amazon.com/Greatest-Salesman-World-Og-Mandino/dp/055327757X">The Greatest Salesman in the World</a> – Og Mandino</li>
                            <li><a target="_blank" href="https://www.amazon.com/Fanatical-Prospecting-Conversations-Leveraging-Mail/dp/1531888984">Fanatical Prospecting</a> - Jeb Blount</li>
                            <li><a target="_blank" href="https://www.amazon.com/Sales-Bible-Ultimate-Resource-Revised/dp/0471456292">The Sales Bible</a> - Jeffrey Gitomer</li>
                            <li><a target="_blank" href="https://www.amazon.com/Pitch-Anything-Innovative-Presenting-Persuading/dp/0071752854">Pitch Anything</a> - Oren Klaff</li>
                            <li><a target="_blank" href="https://www.amazon.com/Little-Red-Book-Selling-Principles/dp/1885167601">The Little Red Book of Selling</a> - Jeffrey Gitomer</li>
                            <li><a target="_blank" href="https://www.amazon.com/Selling-Invisible-Field-Modern-Marketing/dp/0446672319">Selling the Invisible</a> - Harry Beckwith</li>
                            <li><a target="_blank" href="https://www.amazon.com/How-Become-Rainmaker-Getting-Customers/dp/0786865954">How to Become a Rainmaker</a> - Jeffrey Fox</li>
                        </ul>
                    </li>
                </ul>
                <h4 id="career-advice">Career Advice</h4>
                <h5>Salary tools, general tips, and more</h5>
                <ul class="browser-default">
                    <li><a target="_blank" href="http://themuse.com/">theMuse</a> - great resource for career development</li>
                    <li><a target="_blank" href="http://www.theladders.com/">The Ladders</a> - focused on those seeking jobs that pay over $100,000</li>
                    <li><a target="_blank" href="https://www.salary.com/">Salary.com</a> - calculators and tools for compensation</li>
                    <li><a target="_blank" href="https://www.indeed.com/">Indeed.com</a> - another place to find company reviews and see salary comp for sales roles</li>
                    <li><a target="_blank" href="https://www.glassdoor.com/index.htm">Glassdoor.com</a> - research companies and get insights/feedback from real employees </li>
                    <li><a target="_blank" href="https://www.morningbrew.com/">MorningBrew</a> - news to help you get smarter in 5 minutes</li>
                    <li><a target="_blank" href="http://www.crains.com/">Crain’s Newsletter</a> - top business news stories in your market</li>
                    <li><a target="_blank" href="https://www.etinspires.com/">Eric Thomas (Breathe University)</a> - motivational content</li>
                    <li><a target="_blank" href="https://grantcardone.com/">Grant Cardone</a> - content to grow your business, income and life</li>
                    <li><a target="_blank" href="https://ryanestis.com/">Ryan Estis</a> - business performance trends, best practices</li>
                </ul>
                <h4 id="sports-tech">Sports Tech</h4>
                <h5>Groups, accelerators, VC’s and others focused on technology within sports</h5>
                <ul class="browser-default">
                    <li><a target="_blank" href="http://womeninsportstech.org/">Women in Sports Tech</a> - community providing women in sports with growth opportunities</li>
                    <li><a target="_blank" href="https://www.leadsports.com/">Lead Sports</a> - funding and nurturing early-stage sports startups</li>
                    <li><a target="_blank" href="http://www.stadiaventures.com/">Stadia Ventures</a> - accelerator</li>
                    <li><a target="_blank" href="http://www.hypesportsinnovation.com/">http://www.hypesportsinnovation.com/</a> - accelerator</li>
                    <li><a target="_blank" href="https://tpgsportsgroup.com/sportstank/">Sports Tank</a> - Shark Tank-esq competition for sports tech startups</li>
                    <li><a target="_blank" href="http://www.podium.vc/">Podium</a> - venture capital focused on sports businesses</li>
                    <li><a target="_blank" href="http://www.blacklabsports.com/">Black Lab Sports</a> - invest in and ecosystem for sports startups</li>
                    <li><a target="_blank" href="https://www.geekwire.com/sports/">Geekwire Sports</a> - media company focused on sports tech</li>
                </ul>
                <h4 id="whitepapers">Whitepapers/Resources</h4>
                <ul class="browser-default">
                    <li><a target="_blank" href="https://www.sports-management-degrees.com/business-careers/">Complete Guide to Careers in Sports Management</a></li>
                </ul>
                <h4 id="organizations">Professional Organizations/Associations</h4>
                <h5>There are many professional opportunities beyond the “Big 4”</h5>
                <ul class="browser-default">
                    <li><a target="_blank" href="http://www.nba.com/">NBA</a></li>
                    <li><a target="_blank" href="https://www.nfl.com/">NFL</a></li>
                    <li><a target="_blank" href="https://www.mlb.com/">MLB</a></li>
                    <li><a target="_blank" href="https://www.nhl.com/">NHL</a></li>
                    <li><a target="_blank" href="https://www.mlssoccer.com/">MLS</a></li>
                    <li><a target="_blank" href="http://www.ncaa.org/">NCAA</a></li>
                    <li><a target="_blank" href="https://en.wikipedia.org/wiki/Ultimate_Fighting_Championship">UFC</a></li>
                    <li><a target="_blank" href="https://www.usta.com/">USTA</a></li>
                    <li><a target="_blank" href="https://www.pga.com/home">PGA</a></li>
                    <li><a target="_blank" href="http://www.lpga.com/">LPGA</a></li>
                    <li><a target="_blank" href="https://www.nascar.com/">NASCAR</a></li>
                    <li><a target="_blank" href="https://en.wikipedia.org/wiki/Major_League_Lacrosse">MLL</a></li>
                    <li><a target="_blank" href="https://en.wikipedia.org/wiki/National_Lacrosse_League">NLL</a></li>
                    <li><a target="_blank" href="https://en.wikipedia.org/wiki/USA_Rugby_League">USA Rugby</a></li>
                    <li><a target="_blank" href="https://www.teamusa.org/">USOC</a></li>
                    <li><a target="_blank" href="https://www.mlg.com/">Major League Gaming</a></li>
                    <li><a target="_blank" href="https://avp.com/">Association of Volleyball Professionals</a></li>
                    <li><a target="_blank" href="https://www.wwe.com/">WWE</a></li>
                    <li><a target="_blank" href="http://www.milb.com/index.jsp">Minor League Baseball</a></li>
                    <li><a target="_blank" href="https://gleague.nba.com/">NBA G League (G League)</a></li>
                    <li><a target="_blank" href="https://www.xfl.com/">XFL</a></li>
                    <li><a target="_blank" href="https://www.arenafootball.com/">Arena Football League</a></li>
                    <li><a target="_blank" href="https://www.indycar.com/">IndyCar Series</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
